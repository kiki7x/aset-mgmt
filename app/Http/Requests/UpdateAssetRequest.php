<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAssetRequest extends FormRequest
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
            'id' => 'required',
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'manufacturer_id' => 'required|array|min:1|max:1',
            'manufacturer_id.0' => 'required',
            'model_id' => 'required|array|min:1|max:1',
            'model_id.0' => 'required',
            'supplier_id' => 'required|array|min:1|max:1',
            'supplier_id.0' => 'required',
            'serial' => 'required|unique:assets,serial',
            'location_id' => 'required',
            'status_id' => 'required',
            'user_id' => 'required',
            'admin_id' => 'required',
            'purchase_date' => 'required|date',
            'warranty_months' => 'required|integer|min:0',
            'notes' => 'nullable|string',
        ];
    }
}
