<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workspace extends Model
{
    use HasFactory;

    protected $table = 'workspaces';

    public const UPDATED_AT = null;

    protected $fillable = [
        'nama',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'workspace_id');
    }

    public function kandangs(): HasMany
    {
        return $this->hasMany(Kandang::class, 'workspace_id');
    }
}
