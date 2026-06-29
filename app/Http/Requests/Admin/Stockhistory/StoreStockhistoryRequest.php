<?php

namespace App\Http\Requests\Admin\Stockhistory;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockhistoryRequest extends FormRequest
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
            'product_id' => 'required',
            'quantity' => 'required',
            'amount' => 'required',
            'type' => 'nullable'
        ];
    }

    public function passedValidation()
    {
        // dd($epinWithPlan);
        $this->validator->setData(
            $this->safe()->except('type')
                +
                [
                    'type' => 1
                ]
        );
    }
}
