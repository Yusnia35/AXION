<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rule extends Model
{
    use HasFactory;

    protected $table = 'rules';

    public const UPDATED_AT = null;

    protected $fillable = [
        'kode',
        'nama',
        'kesimpulan',
        'level_risiko',
        'bobot_cf',
        'pengurang_skor',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'bobot_cf' => 'decimal:2',
            'pengurang_skor' => 'integer',
            'is_active' => 'boolean',
            'created_at' => 'datetime',
        ];
    }

    public function ruleKondisis(): HasMany
    {
        return $this->hasMany(RuleKondisi::class, 'rule_id');
    }

    public function tindakanRules(): HasMany
    {
        return $this->hasMany(TindakanRule::class, 'rule_id');
    }

    public function analisisRules(): HasMany
    {
        return $this->hasMany(AnalisisRule::class, 'rule_id');
    }

    public function rekomendasis(): HasMany
    {
        return $this->hasMany(Rekomendasi::class, 'rule_id');
    }
}
