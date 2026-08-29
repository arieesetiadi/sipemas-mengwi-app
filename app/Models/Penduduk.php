<?php

namespace App\Models;

use App\Models\Banjar;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penduduk extends Model
{
    protected $table = 'penduduk';

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function banjar(): BelongsTo
    {
        return $this->belongsTo(Banjar::class);
    }
}
