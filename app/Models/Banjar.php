<?php

namespace App\Models;

use App\Models\Penduduk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Banjar extends Model
{
    protected $table = 'banjar';

    protected $guarded = [];

    public function penduduk(): HasMany
    {
        return $this->hasMany(Penduduk::class);
    }
}
