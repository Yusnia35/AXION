<?php

namespace App\Http\Controllers;

use App\Models\Analisis;
use App\Models\Kandang;
use App\Models\Rule;
use App\Models\User;
use App\Models\Workspace;
use App\Services\ExpertSystemInferenceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AnalisisController extends Controller
{
    /**
     * Display expert system analysis results, explainable banner, and inference modal.
     */
    public function index(Request $request, ExpertSystemInferenceService $inferenceService): View
    {
        $currentWorkspace = Workspace::first();
        $currentUser = Auth::user() ?? User::first();

        $analises = Analisis::with([
            'kandang',
            'kelompokAyam',
            'rekomendasis',
            'analisisRules.rule.ruleKondisis',
            'monitoringSensor',
            'kondisiLingkungan',
            'pemeriksaanAyam',
        ])->latest('dibuat_pada')->get();

        $kandangs = Kandang::with(['kelompokAyams', 'sensors'])->get();
        $rules = Rule::with(['ruleKondisis', 'tindakanRules'])->where('is_active', true)->get();

        // Default facts template for the first kandang if available
        $firstKandangId = $kandangs->first()?->id;
        $defaultFacts = $firstKandangId
            ? $inferenceService->gatherFactsForKandang($firstKandangId)
            : [];

        return view('analisis.index', compact(
            'analises',
            'kandangs',
            'rules',
            'defaultFacts',
            'currentWorkspace',
            'currentUser'
        ));
    }

    /**
     * Run interactive diagnosis using forward chaining inference engine.
     */
    public function diagnosa(Request $request, ExpertSystemInferenceService $inferenceService): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'kandang_id' => 'required|exists:kandang,id',
            'kelompok_id' => 'nullable|exists:kelompok_ayam,id',
            'suhu' => 'required|numeric|between:10,50',
            'kelembapan' => 'required|numeric|between:20,100',
            'ventilasi' => 'required|in:baik,cukup,kurang',
            'kebersihan' => 'required|in:bersih,cukup,kotor',
            'kondisi_litter' => 'required|in:kering,lembap,basah',
            'kepadatan' => 'required|in:longgar,ideal,padat',
            'nafsu_makan' => 'required|in:normal,menurun,tidak_mau_makan',
            'aktivitas' => 'required|in:aktif,lesu,sangat_lesu',
            'kondisi_mata' => 'required|in:normal,berair,bengkak',
            'kondisi_bulu' => 'required|in:normal,kusut,rontok',
            'batuk_bersin' => 'required|in:tidak_ada,ringan,sering',
            'kondisi_kotoran' => 'required|in:normal,encer,kehijauan,berdarah',
        ]);

        $userId = Auth::id() ?? User::first()?->id ?? 1;

        $facts = [
            'suhu' => (float) $validated['suhu'],
            'kelembapan' => (float) $validated['kelembapan'],
            'ventilasi' => $validated['ventilasi'],
            'kebersihan' => $validated['kebersihan'],
            'kondisi_litter' => $validated['kondisi_litter'],
            'kepadatan' => $validated['kepadatan'],
            'nafsu_makan' => $validated['nafsu_makan'],
            'aktivitas' => $validated['aktivitas'],
            'kondisi_mata' => $validated['kondisi_mata'],
            'kondisi_bulu' => $validated['kondisi_bulu'],
            'batuk_bersin' => $validated['batuk_bersin'],
            'kondisi_kotoran' => $validated['kondisi_kotoran'],
        ];

        $result = $inferenceService->infer(
            facts: $facts,
            kandangId: (int) $validated['kandang_id'],
            kelompokId: ! empty($validated['kelompok_id']) ? (int) $validated['kelompok_id'] : null,
            userId: $userId,
            saveToDatabase: true
        );

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Analisis sistem pakar berhasil dijalankan!',
                'data' => $result,
            ]);
        }

        return redirect()->route('analisis.index')
            ->with('success', 'Analisis Forward Chaining berhasil dijalankan! Ditemukan '.$result['total_fired'].' aturan aktif dengan skor kesehatan '.$result['health_score'].'/100.')
            ->with('last_analisis_id', $result['analisis']?->id);
    }

    /**
     * Show detail of an analysis session including explainable rules trace.
     */
    public function show(Analisis $analisis): JsonResponse|View
    {
        $analisis->load([
            'kandang',
            'kelompokAyam',
            'user',
            'rekomendasis',
            'analisisRules.rule.ruleKondisis',
            'analisisRules.rule.tindakanRules',
            'monitoringSensor',
            'kondisiLingkungan',
            'pemeriksaanAyam',
        ]);

        if (request()->wantsJson()) {
            return response()->json([
                'analisis' => $analisis,
                'kandang' => $analisis->kandang,
                'kelompok' => $analisis->kelompokAyam,
                'rules' => $analisis->analisisRules->map(fn ($ar) => [
                    'kode' => $ar->rule?->kode,
                    'nama' => $ar->rule?->nama,
                    'kesimpulan' => $ar->rule?->kesimpulan,
                    'level_risiko' => $ar->rule?->level_risiko,
                    'bobot_cf' => $ar->rule?->bobot_cf,
                    'cf_nilai' => $ar->cf_nilai,
                    'pengurang_skor' => $ar->rule?->pengurang_skor,
                    'kondisi' => $ar->rule?->ruleKondisis,
                    'tindakan' => $ar->rule?->tindakanRules,
                ]),
                'rekomendasi' => $analisis->rekomendasis,
            ]);
        }

        $currentWorkspace = Workspace::first();
        $currentUser = Auth::user() ?? User::first();

        return view('analisis.show', compact('analisis', 'currentWorkspace', 'currentUser'));
    }
}
