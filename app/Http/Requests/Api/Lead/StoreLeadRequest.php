<?php

namespace App\Http\Requests\Api\Lead;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'mobile' => 'required',
            'address' => 'required',
            'city' => 'required',
            'product_id' => 'required',
            'user_id' => 'nullable',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'email' => 'nullable',
            'status' => 'required',
            'estimation_amount' => 'required',
            'delivery_date' => 'required',
            'our_customer' => 'required|integer',
            'is_exchangable' => 'required|integer|in:1,2',
            'model' => 'required_if:is_exchangable,1',
            'year' => 'required_if:is_exchangable,1',
            'vehicle_number' => 'required_if:is_exchangable,1',
            'exchangable_amount' => 'required_if:is_exchangable,1',
            'follow_up_date' => 'nullable',
            'market_price' => 'nullable'            
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all(); // array of messages
        $firstError = $errors[0] ?? 'Validation failed';

        throw new HttpResponseException(
            \App\Api\Shared\Responses\Error::response(
                $firstError, // put in 'data'
                422 // proper status code for validation errors
            )
        );
    }

    public function passedValidation()
    {
        $this->validator->setData(
            $this->safe()->except('user_id')
                +
                [
                    'user_id' => Auth::id(),
                ]
        );
    }    
}
