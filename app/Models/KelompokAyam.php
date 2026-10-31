<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KelompokAyam extends Model
{
    use HasFactory;

    protected $table = 'kelompok_ayam';

    public const UPDATED_AT = null;

    protected $fillable = [
        'kandang_id',
        'kode',
        'jumlah_ayam',
        'tanggal_masuk',
        'profil',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_ayam' => 'integer',
            'tanggal_masuk' => 'date',
            'is_active' => 'boolean',
            'created_at' => 'datetime',
        ];
    }

    public function kandang(): BelongsTo
    {
        return $this->belongsTo(Kandang::class, 'kandang_id');
    }

    public function pemeriksaanAyams(): HasMany
    {
        return $this->hasMany(PemeriksaanAyam::class, 'kelompok_id');
    }

    public function analisis(): HasMany
    {
        return $this->hasMany(Analisis::class, 'kelompok_id');
    }
}
