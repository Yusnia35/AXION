<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalisisRule extends Model
{
    use HasFactory;

    protected $table = 'analisis_rule';

    public $timestamps = false;

    protected $fillable = [
        'analisis_id',
        'rule_id',
        'cf_nilai',
    ];

    protected function casts(): array
    {
        return [
            'cf_nilai' => 'decimal:3',
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
