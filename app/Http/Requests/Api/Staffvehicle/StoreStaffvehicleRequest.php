<?php

namespace App\Http\Requests\Api\Staffvehicle;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreStaffvehicleRequest extends FormRequest
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
            'user_id' => 'nullable',
            'bike_model' => 'required',
            'number' => 'required',
            'current_kilometer' => 'required',
            'kilometer_image' => 'required',
            'type' => 'required|in:1,2'
        ];
    }


    public function passedValidation()
    {
        $this->validator->setData(
            $this->safe()->except('user_id')
                +
                [
                    // 'unit' => $quantity?->quantity ?? 0,
                    // 'alter_unit' => $quantity?->bag ?? 0,
                    'user_id' => Auth::id(),
                ]
        );
    }
}

