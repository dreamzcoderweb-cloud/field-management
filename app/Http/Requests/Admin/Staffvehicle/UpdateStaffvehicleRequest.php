<?php

namespace App\Http\Requests\Admin\Staffvehicle;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffvehicleRequest extends FormRequest
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
            'bike_model' => 'required',
            'number' => 'required',
            'current_kilometer' => 'required',
            'kilometer_image' => 'nullable'
        ];
    }
}
