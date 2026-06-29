<?php

namespace App\Http\Requests\Admin\Task;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required',
            'type' => 'required',
            'team_id' => 'required',
            'user_id' => 'required',
            'client_id' => 'nullable',
            'notes' => 'nullable',
            'sale_id' => 'nullable',
            'amount' => 'nullable',
            'start_date' => 'required',
            'end_date' => 'required',
            'assigned_by' => 'nullable',
            'lead_id' => 'nullable'
        ];
    }

    public function passedValidation()
    {
        $this->validator->setData(
            $this->safe()->except('assigned_by')
                +
                [
                    'assigned_by' => Sentinel::getUser()->id,
                ]
        );
    }
}
