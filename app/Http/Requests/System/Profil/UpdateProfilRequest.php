<?php

namespace App\Http\Requests\System\Profil;

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
        $adminId = $this->user('system')->id;

        return [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('admins', 'email')->ignore($adminId)],
            'telepon' => ['nullable', 'string', 'max:20', Rule::unique('admins', 'telepon')->ignore($adminId)],
            'password' => ['sometimes', 'nullable', 'string', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah dipakai user lain.',
            'telepon.max' => 'Nomor telepon maksimal 20 karakter.',
            'telepon.unique' => 'Nomor telepon sudah dipakai user lain.',
            'password.min' => 'Password minimal 8 karakter.',
        ];
    }
}
