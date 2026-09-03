<?php

namespace App\Http\Requests\System\Penduduk;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePendudukRequest extends FormRequest
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
        $pendudukId = $this->route('penduduk')->id;

        return [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:penduduk,email,' . $pendudukId],
            'telepon' => ['nullable', 'string', 'max:20', 'unique:penduduk,telepon,' . $pendudukId],
            'password' => ['sometimes', 'nullable', 'string', 'min:8'],
            'is_active' => ['nullable', 'boolean'],
            'nik' => ['required', 'digits:16', 'unique:penduduk,nik,' . $pendudukId],
            'alamat' => ['required', 'string', 'max:255'],
            'banjar_id' => ['required', 'exists:banjar,id'],
        ];
    }

    /**
     * Pesan error dalam Bahasa Indonesia biar user ngerti.
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah dipakai user lain.',
            'telepon.unique' => 'Nomor telepon sudah dipakai user lain.',
            'password.min' => 'Password minimal 8 karakter.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus 16 digit angka.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.max' => 'Alamat maksimal 255 karakter.',
            'banjar_id.required' => 'Banjar wajib dipilih.',
            'banjar_id.exists' => 'Banjar yang dipilih tidak valid.',
        ];
    }
}
