<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TindakanRule extends Model
{
    use HasFactory;

    protected $table = 'tindakan_rule';

    public $timestamps = false;

    protected $fillable = [
        'rule_id',
        'urutan',
        'tindakan',
        'prioritas',
    ];

    protected function casts(): array
    {
        return [
            'urutan' => 'integer',
        ];
    }

    public function rule(): BelongsTo
    {
        return $this->belongsTo(Rule::class, 'rule_id');
    }
}
