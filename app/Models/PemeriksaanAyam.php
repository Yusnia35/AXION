<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class PemeriksaanAyam extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan_ayam';

    public $timestamps = false;

    protected $fillable = [
        'kelompok_id',
        'nafsu_makan',
        'aktivitas',
        'kondisi_mata',
        'kondisi_bulu',
        'batuk_bersin',
        'kondisi_kotoran',
        'catatan',
        'user_id',
        'dicatat_pada',
    ];

    protected function casts(): array
    {
        return [
            'dicatat_pada' => 'datetime',
        ];
    }

    public function kelompokAyam(): BelongsTo
    {
        return $this->belongsTo(KelompokAyam::class, 'kelompok_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function analisis(): HasMany
    {
        return $this->hasMany(Analisis::class, 'pemeriksaan_id');
    }

    public function kandang(): HasOneThrough
    {
        return $this->hasOneThrough(
            Kandang::class,
            KelompokAyam::class,
            'id',
            'id',
            'kelompok_id',
            'kandang_id'
        );
    }

    /**
     * Evaluasi tingkat risiko klinis kesehatan ayam.
     */
    public function getStatusKlinisAttribute(): string
    {
        if (
            $this->kondisi_kotoran === 'berdarah' ||
            ($this->batuk_bersin === 'sering' && $this->nafsu_makan === 'tidak_mau_makan') ||
            $this->aktivitas === 'sangat_lesu'
        ) {
            return 'kritis';
        }

        if (
            $this->nafsu_makan !== 'normal' ||
            $this->aktivitas !== 'aktif' ||
            $this->kondisi_mata !== 'normal' ||
            $this->kondisi_bulu !== 'normal' ||
            $this->batuk_bersin !== 'tidak_ada' ||
            $this->kondisi_kotoran !== 'normal'
        ) {
            return 'perlu_pantau';
        }

        return 'normal';
    }

    public function getStatusKlinisBadgeAttribute(): string
    {
        return match ($this->status_klinis) {
            'kritis' => 'danger',
            'perlu_pantau' => 'warning',
            default => 'success',
        };
    }

    public function getStatusKlinisLabelAttribute(): string
    {
        return match ($this->status_klinis) {
            'kritis' => 'Bahaya / Kritis',
            'perlu_pantau' => 'Perlu Pantau',
            default => 'Normal / Sehat',
        };
    }

    public function getNafsuMakanFormattedAttribute(): string
    {
        return match ($this->nafsu_makan) {
            'tidak_mau_makan' => 'Tidak Mau Makan',
            'menurun' => 'Menurun',
            default => 'Normal',
        };
    }

    public function getAktivitasFormattedAttribute(): string
    {
        return match ($this->aktivitas) {
            'sangat_lesu' => 'Sangat Lesu',
            'lesu' => 'Lesu',
            default => 'Aktif & Lincah',
        };
    }

    public function getKondisiMataFormattedAttribute(): string
    {
        return match ($this->kondisi_mata) {
            'bengkak' => 'Bengkak',
            'berair' => 'Berair',
            default => 'Normal / Jernih',
        };
    }

    public function getKondisiBuluFormattedAttribute(): string
    {
        return match ($this->kondisi_bulu) {
            'rontok' => 'Rontok',
            'kusut' => 'Kusut / Kusam',
            default => 'Normal & Rapi',
        };
    }

    public function getBatukBersinFormattedAttribute(): string
    {
        return match ($this->batuk_bersin) {
            'sering' => 'Sering (Ngorok)',
            'ringan' => 'Ringan (Sesekali)',
            default => 'Tidak Ada',
        };
    }

    public function getKondisiKotoranFormattedAttribute(): string
    {
        return match ($this->kondisi_kotoran) {
            'berdarah' => 'Berdarah (Kritis)',
            'kehijauan' => 'Kehijauan',
            'encer' => 'Encer (Diare)',
            default => 'Normal Padat',
        };
    }

    public function getIndikasiDiagnosaAttribute(): string
    {
        $gejala = [];

        if ($this->kondisi_kotoran === 'berdarah') {
            $gejala[] = 'Indikasi Koksidiosis (Rule R07)';
        }

        if ($this->batuk_bersin === 'sering' && $this->nafsu_makan !== 'normal') {
            $gejala[] = 'Indikasi Gangguan Pernapasan / CRD (Rule R06)';
        } elseif ($this->batuk_bersin !== 'tidak_ada') {
            $gejala[] = 'Gejala Pernapasan Ringan';
        }

        if ($this->nafsu_makan === 'menurun' || $this->nafsu_makan === 'tidak_mau_makan') {
            $gejala[] = 'Nafsu Makan Turun';
        }

        if ($this->aktivitas === 'sangat_lesu' || $this->aktivitas === 'lesu') {
            $gejala[] = 'Ayam Lesu / Kurang Gerak';
        }

        if ($this->kondisi_mata !== 'normal') {
            $gejala[] = 'Iritasi Mata';
        }

        if ($this->kondisi_kotoran === 'encer' || $this->kondisi_kotoran === 'kehijauan') {
            $gejala[] = 'Feses Tidak Normal / Diare';
        }

        if (empty($gejala)) {
            return 'Kondisi fisik dan perilaku kawanan normal & sehat';
        }

        return implode(' &middot; ', $gejala);
    }
}
