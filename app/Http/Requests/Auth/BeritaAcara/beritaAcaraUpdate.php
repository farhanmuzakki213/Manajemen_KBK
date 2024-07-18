<?php

namespace App\Http\Requests\Auth\BeritaAcara;

use Illuminate\Foundation\Http\FormRequest;

class beritaAcaraUpdate extends FormRequest
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
        return [
            'id_berita_acara' => 'required|integer',
            'file_berita_acara' => 'required|mimes:pdf',
            'tanggal_upload' => 'required|date_format:Y-m-d H:i:s',
            'status_kajur' => 'required',
            'status_kaprodi' => 'required',
        ];
    }
}
