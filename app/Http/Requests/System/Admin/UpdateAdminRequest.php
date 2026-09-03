<?php

namespace App\Http\Requests\System\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
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
        $adminId = $this->route('admin')->id;

        return [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:admins,email,' . $adminId],
            'telepon' => ['nullable', 'string', 'max:20', 'unique:admins,telepon,' . $adminId],
            'role_id' => ['required', 'exists:roles,id'],
            'password' => ['sometimes', 'nullable', 'string', 'min:8'],
            'is_active' => ['nullable', 'boolean'],
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
            'telepon.unique' => 'Nomor telepon sudah dipakai user lain.',
            'role_id.required' => 'Role wajib dipilih.',
            'role_id.exists' => 'Role yang dipilih tidak valid.',
            'password.min' => 'Password minimal 8 karakter.',
        ];
    }
}
