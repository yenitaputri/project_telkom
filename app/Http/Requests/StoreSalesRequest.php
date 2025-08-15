<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalesRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Pastikan ini true agar request dapat diotorisasi
    }

    public function rules()
    {
        return [
            'gambar_sales' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'kode_sales'   => 'required|string|max:255|unique:sales,kode_sales', // <-- Tambahkan aturan unique
            'nama_sales'   => 'required|string|max:255',
            'agency'       => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'gambar_sales.required' => 'Kolom Gambar Sales harus diisi.',
            'gambar_sales.image'    => 'File harus berupa gambar.',
            'gambar_sales.mimes'    => 'Gambar harus berformat JPEG, PNG, atau JPG.',
            'gambar_sales.max'      => 'Ukuran gambar tidak boleh lebih dari 2MB.',

            'kode_sales.required'   => 'Kolom Kode Sales harus diisi.',
            'kode_sales.unique'     => 'Kode sales ":input" sudah digunakan. Silakan gunakan kode sales lain.', // <-- Pesan kustom untuk keunikan
            'kode_sales.string'     => 'Kode sales harus berupa teks.',
            'kode_sales.max'        => 'Kode sales tidak boleh lebih dari :max karakter.',

            'nama_sales.required'   => 'Kolom Nama Sales harus diisi.',
            'nama_sales.string'     => 'Nama sales harus berupa teks.',
            'nama_sales.max'        => 'Nama sales tidak boleh lebih dari :max karakter.',

            'agency.required'       => 'Kolom Agency harus diisi.',
            'agency.string'         => 'Agency harus berupa teks.',
            'agency.max'            => 'Agency tidak boleh lebih dari :max karakter.',
        ];
    }
}