<?php

namespace App\Models;

use App\Models\Kependudukan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Banjar extends Model
{
    protected $table = 'banjar';

    protected $guarded = [];

    public function kependudukan(): HasMany
    {
        return $this->hasMany(Kependudukan::class);
    }
}
