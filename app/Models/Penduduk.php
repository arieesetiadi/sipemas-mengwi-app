<?php

namespace App\Models;

use App\Enums\JenisLampiran;
use App\Enums\StatusPerkawinan;
use App\Models\PengajuanSurat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Penduduk extends Authenticatable
{
    protected $table = 'penduduk';

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
            'status_perkawinan' => StatusPerkawinan::class,
        ];
    }

    public function banjar(): BelongsTo
    {
        return $this->belongsTo(Banjar::class);
    }

    public function pengajuanSurat(): HasMany
    {
        return $this->hasMany(PengajuanSurat::class);
    }

    public function punyaBerkas(): bool
    {
        return filled($this->ktp_path) && filled($this->kk_path);
    }

    public function pathBerkas(JenisLampiran $jenis): ?string
    {
        return $this->{$jenis->kolom()};
    }

    public function simpanBerkas(?UploadedFile $ktp, ?UploadedFile $kk): void
    {
        $berkas = [
            JenisLampiran::KTP->kolom() => $ktp,
            JenisLampiran::KK->kolom() => $kk,
        ];

        $update = [];

        foreach ($berkas as $kolom => $file) {
            if (! $file) {
                continue;
            }

            if ($this->{$kolom}) {
                Storage::disk('local')->delete($this->{$kolom});
            }

            $update[$kolom] = $file->store('berkas/' . $this->id, 'local');
        }

        if ($update !== []) {
            $this->update($update);
        }
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('is_active', true);
    }
}
