<?php

namespace App\Http\Requests\Auth\BeritaAcara;

use Illuminate\Foundation\Http\FormRequest;

class beritaAcaraCreate extends FormRequest
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
            'kajur' => 'required|integer',
            'prodi' => 'required|integer',
            'jenis_kbk_id' => 'required|integer',
            'type' => 'required',
            'file_berita_acara' => 'required|mimes:pdf',
            'tanggal_upload' => 'required|date_format:Y-m-d H:i:s',
            'ver_rps_uas_ids' => 'required|array',
            'ver_rps_uas_ids.*' => 'required|string',
        ];
    }
}
