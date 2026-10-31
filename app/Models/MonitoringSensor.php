<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MonitoringSensor extends Model
{
    use HasFactory;

    protected $table = 'monitoring_sensor';

    public $timestamps = false;

    protected $fillable = [
        'kandang_id',
        'sensor_id',
        'suhu',
        'kelembapan',
        'ventilasi',
        'kebersihan',
        'sumber',
        'user_id',
        'dicatat_pada',
    ];

    protected function casts(): array
    {
        return [
            'suhu' => 'decimal:1',
            'kelembapan' => 'decimal:1',
            'dicatat_pada' => 'datetime',
        ];
    }

    public function kandang(): BelongsTo
    {
        return $this->belongsTo(Kandang::class, 'kandang_id');
    }

    public function sensor(): BelongsTo
    {
        return $this->belongsTo(Sensor::class, 'sensor_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function analisis(): HasMany
    {
        return $this->hasMany(Analisis::class, 'monitoring_id');
    }
}
