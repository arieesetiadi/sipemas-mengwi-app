<?php

namespace App\Http\Requests\Portal\Profil;

use App\Enums\Agama;
use App\Enums\JenisKelamin;
use App\Enums\StatusPerkawinan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfilRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (! $this->filled('telepon')) {
            $this->merge(['telepon' => null]);
        }

        if (! $this->filled('password')) {
            $this->request->remove('password');
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $pendudukId = $this->user('portal')->id;

        return [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('penduduk', 'email')->ignore($pendudukId)],
            'telepon' => ['nullable', 'string', 'max:20', Rule::unique('penduduk', 'telepon')->ignore($pendudukId)],
            'nik' => ['required', 'digits:16', Rule::unique('penduduk', 'nik')->ignore($pendudukId)],
            'alamat' => ['required', 'string', 'max:255'],
            'banjar_id' => ['required', 'exists:banjar,id'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'jenis_kelamin' => ['required', Rule::in(JenisKelamin::values())],
            'agama' => ['required', Rule::in(Agama::values())],
            'status_perkawinan' => ['required', Rule::in(StatusPerkawinan::values())],
            'pekerjaan' => ['required', 'string', 'max:255'],
            'lampiran_ktp' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'lampiran_kk' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'password' => ['sometimes', 'nullable', 'string', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'nama.max' => 'Nama lengkap maksimal 255 karakter.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'telepon.max' => 'Nomor telepon maksimal 20 karakter.',
            'telepon.unique' => 'Nomor telepon sudah terdaftar.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus 16 digit angka.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.max' => 'Alamat maksimal 255 karakter.',
            'banjar_id.required' => 'Banjar wajib dipilih.',
            'banjar_id.exists' => 'Banjar yang dipilih tidak valid.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tempat_lahir.max' => 'Tempat lahir maksimal 255 karakter.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            'tanggal_lahir.before' => 'Tanggal lahir tidak boleh di masa depan.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin yang dipilih tidak valid.',
            'agama.required' => 'Agama wajib dipilih.',
            'agama.in' => 'Agama yang dipilih tidak valid.',
            'status_perkawinan.required' => 'Status perkawinan wajib dipilih.',
            'status_perkawinan.in' => 'Status perkawinan yang dipilih tidak valid.',
            'pekerjaan.required' => 'Pekerjaan wajib diisi.',
            'pekerjaan.max' => 'Pekerjaan maksimal 255 karakter.',
            'lampiran_ktp.mimes' => 'KTP harus berupa JPG, PNG, atau PDF.',
            'lampiran_ktp.max' => 'Ukuran KTP maksimal 2MB.',
            'lampiran_kk.mimes' => 'KK harus berupa JPG, PNG, atau PDF.',
            'lampiran_kk.max' => 'Ukuran KK maksimal 2MB.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ];
    }
}
