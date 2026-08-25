<?php

namespace App\Models;

use App\Enums\Role as RoleEnum;
use App\Models\Kependudukan;
use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
            'role_id' => 'integer',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function kependudukan(): HasOne
    {
        return $this->hasOne(Kependudukan::class);
    }

    public function isMasyarakat(): bool
    {
        return $this->role?->label === RoleEnum::Masyarakat->value;
    }
}
