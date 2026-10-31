<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rekomendasi extends Model
{
    use HasFactory;

    protected $table = 'rekomendasi';

    public $timestamps = false;

    protected $fillable = [
        'analisis_id',
        'rule_id',
        'tindakan',
        'prioritas',
        'status',
        'selesai_pada',
        'dibuat_pada',
    ];

    protected function casts(): array
    {
        return [
            'selesai_pada' => 'datetime',
            'dibuat_pada' => 'datetime',
        ];
    }

    public function analisis(): BelongsTo
    {
        return $this->belongsTo(Analisis::class, 'analisis_id');
    }

    public function rule(): BelongsTo
    {
        return $this->belongsTo(Rule::class, 'rule_id');
    }
}
