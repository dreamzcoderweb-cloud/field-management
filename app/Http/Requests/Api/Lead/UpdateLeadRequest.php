<?php

namespace App\Http\Requests\Api\Lead;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdateLeadRequest extends FormRequest
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

    public function rules(): array
    {
        return [
            'status' => 'required|integer',
            // 'latitude' => 'required_if:status,4|nullable',
            // 'longitude' => 'required_if:status,4|nullable',
        ];
    }
}
