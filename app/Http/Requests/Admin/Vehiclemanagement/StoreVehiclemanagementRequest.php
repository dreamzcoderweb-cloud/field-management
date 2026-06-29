<?php

namespace App\Http\Requests\Admin\Vehiclemanagement;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehiclemanagementRequest extends FormRequest
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
            'vehicle_id' => 'required',
            'driver_name' => 'required',
            'location' => 'required',
            'distance' => 'required',
            'fuel' => 'required',
            'notes' => 'nullable'
        ];
    }
}
