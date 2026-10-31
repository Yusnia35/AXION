<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Analisis extends Model
{
    use HasFactory;

    protected $table = 'analisis';

    public $timestamps = false;

    protected $fillable = [
        'kandang_id',
        'kelompok_id',
        'monitoring_id',
        'kondisi_id',
        'pemeriksaan_id',
        'health_score',
        'level_risiko',
        'status_kandang',
        'cf_gabungan',
        'ringkasan',
        'user_id',
        'dibuat_pada',
    ];

    protected function casts(): array
    {
        return [
            'health_score' => 'integer',
            'cf_gabungan' => 'decimal:3',
            'dibuat_pada' => 'datetime',
        ];
    }

    public function kandang(): BelongsTo
    {
        return $this->belongsTo(Kandang::class, 'kandang_id');
    }

    public function kelompokAyam(): BelongsTo
    {
        return $this->belongsTo(KelompokAyam::class, 'kelompok_id');
    }

    public function monitoringSensor(): BelongsTo
    {
        return $this->belongsTo(MonitoringSensor::class, 'monitoring_id');
    }

    public function kondisiLingkungan(): BelongsTo
    {
        return $this->belongsTo(KondisiLingkungan::class, 'kondisi_id');
    }

    public function pemeriksaanAyam(): BelongsTo
    {
        return $this->belongsTo(PemeriksaanAyam::class, 'pemeriksaan_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function analisisRules(): HasMany
    {
        return $this->hasMany(AnalisisRule::class, 'analisis_id');
    }

    public function rekomendasis(): HasMany
    {
        return $this->hasMany(Rekomendasi::class, 'analisis_id');
    }
}
