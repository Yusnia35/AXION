<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RuleKondisi extends Model
{
    use HasFactory;

    protected $table = 'rule_kondisi';

    public $timestamps = false;

    protected $fillable = [
        'rule_id',
        'parameter',
        'operator',
        'nilai',
    ];

    public function rule(): BelongsTo
    {
        return $this->belongsTo(Rule::class, 'rule_id');
    }
}
