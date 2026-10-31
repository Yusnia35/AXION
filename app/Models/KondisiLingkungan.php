<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KondisiLingkungan extends Model
{
    use HasFactory;

    protected $table = 'kondisi_lingkungan';

    public $timestamps = false;

    protected $fillable = [
        'kandang_id',
        'ventilasi',
        'kebersihan',
        'kondisi_litter',
        'kepadatan',
        'user_id',
        'dicatat_pada',
    ];

    protected function casts(): array
    {
        return [
            'dicatat_pada' => 'datetime',
        ];
    }

    public function kandang(): BelongsTo
    {
        return $this->belongsTo(Kandang::class, 'kandang_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function analisis(): HasMany
    {
        return $this->hasMany(Analisis::class, 'kondisi_id');
    }
}
