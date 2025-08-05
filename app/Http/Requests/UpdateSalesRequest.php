<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSalesRequest extends FormRequest
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
    public function rules()
{
    return [
        'kode_sales' => 'required|string|max:255',
        'nama_sales' => 'required|string|max:255',
        'agency' => 'required|string|max:255',
        'gambar_sales' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ];
}

}
