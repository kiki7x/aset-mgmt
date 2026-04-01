<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssetRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Pastikan ini sesuai dengan kebutuhan otorisasi
    }

    public function rules()
    {
        return [
            'id' => 'required|exists:asettiks,id',
            'name' => 'required|string|max:255',
            'classification_id' => 'required|exists:classifications,id',
            'category_id' => 'required|exists:categories,id',
            'admin_id' => 'required|exists:admins,id',
            'client_id' => 'required|exists:clients,id',
            'user_id' => 'required|exists:users,id',
            'manufacturer_id' => 'required|exists:manufacturers,id',
            'model_id' => 'required|exists:models,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'status_id' => 'required|exists:statuses,id',
            'purchase_date' => 'required|date',
            'warranty_months' => 'required|integer',
            'tag' => 'required|string|max:255',
            'serial' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'location_id' => 'required|exists:locations,id',
            'customfields' => 'nullable|string',
            'qrvalue' => 'nullable|string',
        ];
    }
}
