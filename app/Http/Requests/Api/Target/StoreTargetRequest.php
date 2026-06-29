<?php

namespace App\Http\Requests\Api\Target;

use Illuminate\Foundation\Http\FormRequest;

class StoreTargetRequest extends FormRequest
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
            'name' => "required",
            "team_id" => "required",
            "user_id" => "required",
            // 'product_id' => ['required', 'array', 'min:1'],
            // 'product_id.*' => ['required', 'integer', 'exists:products,id'],
            // 'target' => ['required', 'array', 'min:1'],
            // 'target.*' => ['required', 'integer', 'min:1'],
            "from" => "required",
            "to" => "required",
            "sale_count" => 'required',
            "incentive" => ["required", 'array', 'min:1'],
            "incentive.*" => ["required", 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            "team_id.required" => "Select a valid team",
            "user_id.required" => "Select a valid user",
            'product_id.*.required' => 'Each product is required.',
            'product_id.*.exists' => 'Selected product does not exist.',
            'target.*.required' => 'Each target value is required.',
            'target.*.integer' => 'Target must be a whole number.',
            // 'to.after_or_equal' => 'The end date must be the same as or after the start date.',
        ];
    }
}
