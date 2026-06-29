<?php

namespace App\Http\Requests\Admin\Sale;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSaleRequest extends FormRequest
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
            'client_id' => 'required',
            'bank_id' => 'required',
            'interest' => 'required',
            'amount' => 'required',
            'is_exchangable' => 'required|boolean',
            'exchangable_item' => 'required_if:is_exchangable,1',
            'exchangable_amount' => 'required_if:is_exchangable,1',
            'paid_advance' => 'required|boolean',
            'advance_amount' => 'required_if:paid_advance,1',
            'paid_amount' => 'required',
            'balance' => 'required',
            'emi_applicable' => 'required|boolean',
            'emi_amount' => 'required_if:emi_applicable,1',
            'emi_month' => 'required_if:emi_applicable,1',
            'emi_date' => 'required_if:emi_applicable,1',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required'        => 'Select a product.',
            'client_id.required'         => 'Select a client.',
            'bank_id.required'           => 'Select a bank.',

            'is_exchangable.required'    => 'Select an exchangeable type.',
            'is_exchangable.boolean'     => 'Exchangeable type must be true or false.',
            'exchangable_item.required_if'  => 'The exchangeable item is required.',
            'exchangable_amount.required_if' => 'The exchangeable amount is required.',

            'paid_advance.required'      => 'Select a paid advance type.',
            'paid_advance.boolean'       => 'Paid advance must be true or false.',
            'advance_amount.required_if' => 'The advance amount is required.',
            'paid_amount.required'       => 'The paid amount is required.',
            'balance.required'           => 'The balance is required.',

            'emi_applicable.required'    => 'Select an EMI applicable type.',
            'emi_applicable.boolean'     => 'EMI applicable must be true or false.',
            'emi_amount.required_if'     => 'The monthly EMI amount is required.',
            'emi_month.required_if'      => 'The EMI month is required.',
            'emi_date.required_if'       => 'Select a valid EMI date.',
        ];
    }
}
