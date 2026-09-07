<?php

namespace App\Models;

use App\Enums\JenisLampiran;
use App\Models\PengajuanSurat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lampiran extends Model
{
    protected $table = 'lampiran';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'jenis_lampiran' => JenisLampiran::class,
        ];
    }

    public function pengajuanSurat(): BelongsTo
    {
        return $this->belongsTo(PengajuanSurat::class);
    }
}
