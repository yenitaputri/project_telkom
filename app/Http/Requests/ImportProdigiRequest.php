<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportProdigiRequest extends FormRequest
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
            'file_upload' => 'required|mimes:xlsx,xls,csv|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'file_upload.required' => 'File Excel wajib diunggah.',
            'file_upload.mimes' => 'Format file harus .xlsx, .xls, atau .csv.',
            'file_upload.max' => 'Ukuran file maksimal 2MB.',
        ];
    }
}
