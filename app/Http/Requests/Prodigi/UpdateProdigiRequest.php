<?php

namespace App\Http\Requests\Prodigi;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProdigiRequest extends FormRequest
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
            'order_id' => ['nullable', 'string', 'max:255'],
            'nd' => ['nullable', 'string', 'max:255'],
            'customer_name' => ['required', 'string', 'max:255'],
            'witel' => ['nullable', 'string', 'max:255'],
            'telda' => ['nullable', 'string', 'max:255'],
            'produk' => ['nullable', 'string', 'max:255'],
            'tanggal_ps' => ['nullable', 'date'],
            'rev' => ['nullable', 'string', 'max:255'],
            'device' => ['nullable', 'string', 'max:255'],
        ];
    }
}
