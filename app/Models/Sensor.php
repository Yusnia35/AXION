<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sensor extends Model
{
    use HasFactory;

    protected $table = 'sensor';

    public $timestamps = false;

    protected $fillable = [
        'kandang_id',
        'nama',
        'jenis',
        'perangkat',
        'mikrokontroler',
        'status',
        'last_sync',
    ];

    protected function casts(): array
    {
        return [
            'last_sync' => 'datetime',
        ];
    }

    public function kandang(): BelongsTo
    {
        return $this->belongsTo(Kandang::class, 'kandang_id');
    }

    public function monitoringSensors(): HasMany
    {
        return $this->hasMany(MonitoringSensor::class, 'sensor_id');
    }
}
