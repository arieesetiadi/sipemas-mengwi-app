<?php

namespace App\Http\Requests\System\Pengajuan;

use Illuminate\Foundation\Http\FormRequest;

class TolakPengajuanSuratRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'catatan_penolakan' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'catatan_penolakan.required' => 'Catatan penolakan wajib diisi.',
            'catatan_penolakan.max' => 'Catatan penolakan maksimal 255 karakter.',
        ];
    }
}
