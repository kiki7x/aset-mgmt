<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JadwalPemeliharaanRequest extends FormRequest
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
            'asset_id' => 'required',
            'name' => 'required|min:3',
            'frequency' => 'required',
            'start_date' => 'required|date',
            'next_date' => 'required|date',
            'status' => 'required',
            'customfields' => 'nullable|string',
        ];
    }
}
