<?php

namespace App\Http\Requests\Portal\Pengajuan;

use App\Enums\StatusPerkawinan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePengajuanSuratRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'catatan' => ['nullable', 'string', 'max:255'],
            'lampiran_ktp' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'lampiran_kk' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ];

        return match ($this->route('pengajuan')->jenisSurat->kode) {
            'SKD' => [
                ...$rules,
                'status_perkawinan' => ['required', Rule::in(StatusPerkawinan::values())],
            ],
            'SKU' => [
                ...$rules,
                'nama_usaha' => ['required', 'string', 'max:255'],
                'lokasi_usaha' => ['required', 'string', 'max:255'],
            ],
            'SP' => [
                ...$rules,
                'tujuan_instansi' => ['required', 'string', 'max:255'],
                'keperluan' => ['required', 'string', 'max:255'],
            ],
            default => $rules,
        };
    }

    public function messages(): array
    {
        return [
            'status_perkawinan.required' => 'Status perkawinan wajib dipilih.',
            'status_perkawinan.in' => 'Status perkawinan yang dipilih tidak valid.',
            'nama_usaha.required' => 'Nama usaha wajib diisi.',
            'nama_usaha.max' => 'Nama usaha maksimal 255 karakter.',
            'lokasi_usaha.required' => 'Lokasi usaha wajib diisi.',
            'lokasi_usaha.max' => 'Lokasi usaha maksimal 255 karakter.',
            'tujuan_instansi.required' => 'Tujuan instansi wajib diisi.',
            'tujuan_instansi.max' => 'Tujuan instansi maksimal 255 karakter.',
            'keperluan.required' => 'Keperluan wajib diisi.',
            'keperluan.max' => 'Keperluan maksimal 255 karakter.',
            'catatan.max' => 'Catatan maksimal 255 karakter.',
            'lampiran_ktp.mimes' => 'KTP harus berupa JPG, PNG, atau PDF.',
            'lampiran_ktp.max' => 'Ukuran KTP maksimal 2MB.',
            'lampiran_kk.mimes' => 'KK harus berupa JPG, PNG, atau PDF.',
            'lampiran_kk.max' => 'Ukuran KK maksimal 2MB.',
        ];
    }
}
