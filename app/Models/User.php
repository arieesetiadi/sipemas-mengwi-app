<?php

namespace App\Models;

use App\Enums\Role as RoleEnum;
use App\Models\Penduduk;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
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

    public function penduduk(): HasOne
    {
        return $this->hasOne(Penduduk::class);
    }

    public function isPenduduk(): bool
    {
        return $this->role?->label === RoleEnum::Penduduk->value;
    }

    public function scopeAdmin(Builder $query): Builder
    {
        return $query->whereHas('role', fn (Builder $q) => $q->whereNot('label', RoleEnum::Penduduk->value));
    }

    public function scopePendudukUser(Builder $query): Builder
    {
        return $query->whereHas('role', fn (Builder $q) => $q->where('label', RoleEnum::Penduduk->value));
    }
}
