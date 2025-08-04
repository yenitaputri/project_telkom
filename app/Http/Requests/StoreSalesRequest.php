<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalesRequest extends FormRequest
{
    public function authorize()
    {
        return true; // pastikan true agar bisa dijalankan
    }

    public function rules()
    {
        return [
            'gambar_sales' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'kode_sales'   => 'required|string|max:255',
            'nama_sales'   => 'required|string|max:255',
            'agency'       => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'gambar_sales.required' => 'Kolom Gambar Sales harus diisi.',
            'kode_sales.required'   => 'Kolom Kode Sales harus diisi.',
            'nama_sales.required'   => 'Kolom Nama Sales harus diisi.',
            'agency.required'       => 'Kolom Agency harus diisi.',
        ];
    }
}
