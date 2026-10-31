<?php

namespace App\Services;

use App\Models\Analisis;
use App\Models\AnalisisRule;
use App\Models\Kandang;
use App\Models\KondisiLingkungan;
use App\Models\MonitoringSensor;
use App\Models\PemeriksaanAyam;
use App\Models\Rekomendasi;
use App\Models\Rule;
use Illuminate\Support\Facades\DB;

class ExpertSystemInferenceService
{
    /**
     * Gather the latest known facts for a kandang and flock from database.
     *
     * @return array<string, mixed>
     */
    public function gatherFactsForKandang(int $kandangId, ?int $kelompokId = null): array
    {
        $kandang = Kandang::with('latestAnalisis')->find($kandangId);

        $latestMonitoring = MonitoringSensor::where('kandang_id', $kandangId)
            ->latest('dicatat_pada')
            ->first();

        $latestKondisi = KondisiLingkungan::where('kandang_id', $kandangId)
            ->latest('dicatat_pada')
            ->first();

        $pemeriksaanQuery = PemeriksaanAyam::query();
        if ($kelompokId) {
            $pemeriksaanQuery->where('kelompok_id', $kelompokId);
        } else {
            $pemeriksaanQuery->whereHas('kelompokAyam', function ($q) use ($kandangId) {
                $q->where('kandang_id', $kandangId);
            });
        }
        $latestPemeriksaan = $pemeriksaanQuery->latest('dicatat_pada')->first();

        return [
            'kandang_id' => $kandangId,
            'kelompok_id' => $kelompokId ?? $latestPemeriksaan?->kelompok_id,
            'monitoring_id' => $latestMonitoring?->id,
            'kondisi_id' => $latestKondisi?->id,
            'pemeriksaan_id' => $latestPemeriksaan?->id,
            'suhu' => $latestMonitoring ? (float) $latestMonitoring->suhu : 28.5,
            'kelembapan' => $latestMonitoring ? (float) $latestMonitoring->kelembapan : 68.0,
            'ventilasi' => $latestKondisi?->ventilasi ?? $latestMonitoring?->ventilasi ?? 'cukup',
            'kebersihan' => $latestKondisi?->kebersihan ?? $latestMonitoring?->kebersihan ?? 'bersih',
            'kondisi_litter' => $latestKondisi?->kondisi_litter ?? 'kering',
            'kepadatan' => $latestKondisi?->kepadatan ?? 'ideal',
            'nafsu_makan' => $latestPemeriksaan?->nafsu_makan ?? 'normal',
            'aktivitas' => $latestPemeriksaan?->aktivitas ?? 'aktif',
            'kondisi_mata' => $latestPemeriksaan?->kondisi_mata ?? 'normal',
            'kondisi_bulu' => $latestPemeriksaan?->kondisi_bulu ?? 'normal',
            'batuk_bersin' => $latestPemeriksaan?->batuk_bersin ?? 'tidak_ada',
            'kondisi_kotoran' => $latestPemeriksaan?->kondisi_kotoran ?? 'normal',
        ];
    }

    /**
     * Run forward chaining inference against expert rules.
     *
     * @param  array<string, mixed>  $facts
     * @return array<string, mixed>
     */
    public function infer(
        array $facts,
        ?int $kandangId = null,
        ?int $kelompokId = null,
        ?int $monitoringId = null,
        ?int $kondisiId = null,
        ?int $pemeriksaanId = null,
        ?int $userId = null,
        bool $saveToDatabase = true
    ): array {
        $rules = Rule::with(['ruleKondisis', 'tindakanRules'])
            ->where('is_active', true)
            ->get();

        $firedRules = [];
        $rulesEvaluationTrace = [];
        $totalPengurangSkor = 0;
        $cfValues = [];

        foreach ($rules as $rule) {
            $allConditionsMet = true;
            $conditionTraces = [];

            if ($rule->ruleKondisis->isEmpty()) {
                $allConditionsMet = false;
            }

            foreach ($rule->ruleKondisis as $kondisi) {
                $param = $kondisi->parameter;
                $operator = $kondisi->operator;
                $targetVal = $kondisi->nilai;
                $actualVal = $facts[$param] ?? null;

                $isMet = $this->evaluateCondition($actualVal, $operator, $targetVal, $param);

                $conditionTraces[] = [
                    'parameter' => $param,
                    'operator' => $operator,
                    'nilai_target' => $targetVal,
                    'nilai_aktual' => $actualVal,
                    'terpenuhi' => $isMet,
                ];

                if (! $isMet) {
                    $allConditionsMet = false;
                }
            }

            $rulesEvaluationTrace[] = [
                'rule_id' => $rule->id,
                'kode' => $rule->kode,
                'nama' => $rule->nama,
                'kesimpulan' => $rule->kesimpulan,
                'level_risiko' => $rule->level_risiko,
                'bobot_cf' => (float) $rule->bobot_cf,
                'pengurang_skor' => (int) $rule->pengurang_skor,
                'terpicu' => $allConditionsMet,
                'kondisi' => $conditionTraces,
                'tindakan' => $rule->tindakanRules->map(fn ($t) => [
                    'tindakan' => $t->tindakan,
                    'prioritas' => $t->prioritas,
                ])->toArray(),
            ];

            if ($allConditionsMet) {
                $firedRules[] = $rule;
                $totalPengurangSkor += (int) $rule->pengurang_skor;
                $cfValues[] = (float) $rule->bobot_cf;
            }
        }

        // Calculate combined Certainty Factor
        $cfGabungan = $this->combineCertaintyFactors($cfValues);

        // Calculate Health Score (100 - total penalty, min 0)
        $healthScore = max(0, min(100, 100 - $totalPengurangSkor));

        // Determine Level Risiko
        $levelRisiko = 'rendah';
        $riskOrder = ['rendah' => 1, 'sedang' => 2, 'tinggi' => 3, 'kritis' => 4];
        $highestRiskRank = 1;

        foreach ($firedRules as $fRule) {
            $rank = $riskOrder[$fRule->level_risiko] ?? 1;
            if ($rank > $highestRiskRank) {
                $highestRiskRank = $rank;
                $levelRisiko = $fRule->level_risiko;
            }
        }

        // Determine Status Kandang
        if ($levelRisiko === 'kritis' || $healthScore < 60) {
            $statusKandang = 'bahaya';
        } elseif (in_array($levelRisiko, ['tinggi', 'sedang'], true) || $healthScore < 85) {
            $statusKandang = 'perlu_pantau';
        } else {
            $statusKandang = 'normal';
        }

        // Generate diagnosis summary
        if (! empty($firedRules)) {
            $conclusions = array_map(fn (Rule $r) => $r->kesimpulan, $firedRules);
            $ringkasan = 'Terdeteksi '.count($firedRules).' indikasi risiko pakar: '.implode(' ', $conclusions);
        } else {
            $ringkasan = 'Kondisi mikroklimat kandang dan kesehatan kawanan ayam terpantau normal dan optimal.';
        }

        $analisisModel = null;
        $createdRekomendasi = [];

        // Save to Database if requested and kandangId is present
        if ($saveToDatabase && $kandangId) {
            $analisisModel = DB::transaction(function () use (
                $kandangId,
                $kelompokId,
                $monitoringId,
                $kondisiId,
                $pemeriksaanId,
                $healthScore,
                $levelRisiko,
                $statusKandang,
                $cfGabungan,
                $ringkasan,
                $userId,
                $firedRules,
                &$createdRekomendasi
            ) {
                $analisis = Analisis::create([
                    'kandang_id' => $kandangId,
                    'kelompok_id' => $kelompokId,
                    'monitoring_id' => $monitoringId,
                    'kondisi_id' => $kondisiId,
                    'pemeriksaan_id' => $pemeriksaanId,
                    'health_score' => $healthScore,
                    'level_risiko' => $levelRisiko,
                    'status_kandang' => $statusKandang,
                    'cf_gabungan' => $cfGabungan,
                    'ringkasan' => $ringkasan,
                    'user_id' => $userId,
                    'dibuat_pada' => now(),
                ]);

                foreach ($firedRules as $rule) {
                    AnalisisRule::create([
                        'analisis_id' => $analisis->id,
                        'rule_id' => $rule->id,
                        'cf_nilai' => $rule->bobot_cf,
                    ]);

                    foreach ($rule->tindakanRules as $tindakan) {
                        $rek = Rekomendasi::create([
                            'analisis_id' => $analisis->id,
                            'rule_id' => $rule->id,
                            'tindakan' => $tindakan->tindakan,
                            'prioritas' => $tindakan->prioritas,
                            'status' => 'baru',
                            'dibuat_pada' => now(),
                        ]);
                        $createdRekomendasi[] = $rek;
                    }
                }

                return $analisis;
            });
        }

        return [
            'analisis' => $analisisModel,
            'health_score' => $healthScore,
            'level_risiko' => $levelRisiko,
            'status_kandang' => $statusKandang,
            'cf_gabungan' => $cfGabungan,
            'ringkasan' => $ringkasan,
            'total_rules' => $rules->count(),
            'total_fired' => count($firedRules),
            'fired_rules' => $firedRules,
            'rules_evaluation' => $rulesEvaluationTrace,
            'facts_evaluated' => $facts,
            'rekomendasi_diterbitkan' => $createdRekomendasi,
        ];
    }

    /**
     * Evaluate single condition.
     */
    public function evaluateCondition(mixed $actualVal, string $operator, string $targetVal, string $parameter): bool
    {
        if ($actualVal === null || $actualVal === '') {
            return false;
        }

        // Numeric parameters
        if (in_array($parameter, ['suhu', 'kelembapan'], true) || is_numeric($actualVal) && is_numeric($targetVal)) {
            $numActual = (float) $actualVal;
            $numTarget = (float) $targetVal;

            return match ($operator) {
                '>' => $numActual > $numTarget,
                '>=' => $numActual >= $numTarget,
                '<' => $numActual < $numTarget,
                '<=' => $numActual <= $numTarget,
                '=' => abs($numActual - $numTarget) < 0.0001,
                '!=' => abs($numActual - $numTarget) >= 0.0001,
                default => false,
            };
        }

        // Categorical / string parameters
        $strActual = strtolower(trim((string) $actualVal));
        $strTarget = strtolower(trim($targetVal));

        return match ($operator) {
            '=' => $strActual === $strTarget,
            '!=' => $strActual !== $strTarget,
            default => $strActual === $strTarget,
        };
    }

    /**
     * Combine positive Certainty Factor values.
     * Formula: CF_combine(CF1, CF2) = CF1 + CF2 * (1 - CF1)
     *
     * @param  array<int, float>  $cfValues
     */
    public function combineCertaintyFactors(array $cfValues): float
    {
        if (empty($cfValues)) {
            return 0.0;
        }

        $combined = $cfValues[0];
        $count = count($cfValues);

        for ($i = 1; $i < $count; $i++) {
            $next = $cfValues[$i];
            $combined = $combined + ($next * (1.0 - $combined));
        }

        return round($combined, 3);
    }
}
