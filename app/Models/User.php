<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\File;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    public const UPDATED_AT = null;

    protected $fillable = [
        'workspace_id',
        'nama',
        'email',
        'foto',
        'password_hash',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'created_at' => 'datetime',
        ];
    }

    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }

    public function getAuthPasswordName(): string
    {
        return 'password_hash';
    }

    public function isAdmin(): bool
    {
        return strtolower((string) $this->role) === 'admin';
    }

    public function getFotoUrlAttribute(): ?string
    {
        if ($this->foto && File::exists(public_path('uploads/avatars/'.$this->foto))) {
            return asset('uploads/avatars/'.$this->foto);
        }

        return null;
    }

    public function getInitialsAttribute(): string
    {
        $words = array_values(array_filter(explode(' ', trim((string) $this->nama))));
        if (empty($words)) {
            return 'U';
        }
        $first = strtoupper(substr($words[0], 0, 1));
        $second = isset($words[1]) ? strtoupper(substr($words[1], 0, 1)) : (strlen($words[0]) > 1 ? strtoupper(substr($words[0], 1, 1)) : '');

        return $first.$second;
    }

    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class, 'workspace_id');
    }

    public function monitoringSensors(): HasMany
    {
        return $this->hasMany(MonitoringSensor::class, 'user_id');
    }

    public function kondisiLingkungans(): HasMany
    {
        return $this->hasMany(KondisiLingkungan::class, 'user_id');
    }

    public function pemeriksaanAyams(): HasMany
    {
        return $this->hasMany(PemeriksaanAyam::class, 'user_id');
    }

    public function analisis(): HasMany
    {
        return $this->hasMany(Analisis::class, 'user_id');
    }
}
