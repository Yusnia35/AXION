<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kandang extends Model
{
    use HasFactory;

    protected $table = 'kandang';

    public const UPDATED_AT = null;

    protected $fillable = [
        'workspace_id',
        'nama',
        'jenis_ayam',
        'tipe_kandang',
        'lokasi',
        'kapasitas',
    ];

    protected function casts(): array
    {
        return [
            'kapasitas' => 'integer',
            'created_at' => 'datetime',
        ];
    }

    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class, 'workspace_id');
    }

    public function sensors(): HasMany
    {
        return $this->hasMany(Sensor::class, 'kandang_id');
    }

    public function monitoringSensors(): HasMany
    {
        return $this->hasMany(MonitoringSensor::class, 'kandang_id');
    }

    public function kondisiLingkungans(): HasMany
    {
        return $this->hasMany(KondisiLingkungan::class, 'kandang_id');
    }

    public function kelompokAyams(): HasMany
    {
        return $this->hasMany(KelompokAyam::class, 'kandang_id');
    }

    public function activeKelompokAyams(): HasMany
    {
        return $this->hasMany(KelompokAyam::class, 'kandang_id')->where('is_active', true);
    }

    public function analisis(): HasMany
    {
        return $this->hasMany(Analisis::class, 'kandang_id');
    }

    public function latestAnalisis(): HasOne
    {
        return $this->hasOne(Analisis::class, 'kandang_id')->latestOfMany('dibuat_pada');
    }

    public function getTotalAyamAttribute(): int
    {
        return (int) $this->kelompokAyams->where('is_active', true)->sum('jumlah_ayam');
    }

    public function getPersentaseTerisiAttribute(): int
    {
        if ($this->kapasitas <= 0) {
            return 0;
        }

        return (int) min(100, round(($this->total_ayam / $this->kapasitas) * 100));
    }

    public function getHealthScoreAttribute(): int
    {
        return (int) ($this->latestAnalisis?->health_score ?? 85);
    }

    public function getStatusKandangAttribute(): string
    {
        return $this->latestAnalisis?->status_kandang ?? 'normal';
    }

    public function getTipeKandangFormattedAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->tipe_kandang));
    }
}
