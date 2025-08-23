<?php

namespace App\Http\Requests\Pelanggan;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePelangganRequest extends FormRequest
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
            'no_internet' => 'required|string|max:255',
            'no_digital' => 'nullable|string|max:255',
            'tanggal_ps' => 'required|date',
            'kecepatan' => 'nullable|string|max:255',
            'bulan' => 'nullable|integer|min:1|max:12',
            'tahun' => 'nullable|integer|min:2000|max:' . date('Y'),
            'datel' => 'nullable|string|max:255',
            'ro' => 'nullable|string|max:255',
            'sto' => 'nullable|string|max:255',
            'nama' => 'required|string|max:255',
            'segmen' => 'nullable|string|max:255',
            'kcontact' => 'nullable|string|max:255',
            'jenis_layanan' => 'nullable|string|max:255',
            'channel' => 'nullable|string|max:255',
            'kode_sales' => 'nullable|string|max:255',
            'nama_sf' => 'nullable|string|max:255',
            'agency' => 'nullable|string|max:255',
        ];
    }
}
