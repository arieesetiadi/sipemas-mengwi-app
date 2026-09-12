<?php

namespace App\Models;

use App\Enums\StatusPerkawinan;
use App\Enums\StatusSurat;
use App\Models\Admin;
use App\Models\JenisSurat;
use App\Models\Lampiran;
use App\Models\Penduduk;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PengajuanSurat extends Model
{
    protected $table = 'pengajuan_surat';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'status' => StatusSurat::class,
            'status_perkawinan' => StatusPerkawinan::class,
            'diverifikasi_pada' => 'datetime',
            'ditolak_pada' => 'datetime',
            'disetujui_pada' => 'datetime',
        ];
    }

    #[Scope]
    protected function milikPenduduk(Builder $query, int $pendudukId): void
    {
        $query->where('penduduk_id', $pendudukId);
    }

    public function penduduk(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class);
    }

    public function jenisSurat(): BelongsTo
    {
        return $this->belongsTo(JenisSurat::class);
    }

    public function lampiran(): HasMany
    {
        return $this->hasMany(Lampiran::class);
    }

    public function diverifikasiOleh(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'diverifikasi_oleh');
    }

    public function ditolakOleh(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'ditolak_oleh');
    }

    public function disetujuiOleh(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'disetujui_oleh');
    }
}
