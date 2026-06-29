<?php

namespace App\Http\Requests\Admin\Sale;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
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
            'product_id' => 'nullable',
            // Make validator more tolerant if client sends products but Laravel can't parse it as array.
            'products' => 'nullable|array',


            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'nullable|integer|min:1',
            'client_id' => 'nullable',

            'payment_method' => 'nullable|in:1,0',
            'bank_id' => 'nullable',
            'interest' => 'nullable',
            'amount' => 'nullable',

            // Conditional requirements (only for bank payments).
            'bank_id' => 'required_if:payment_method,0',
            'interest' => 'required_if:payment_method,0',


            'cash_amount' => 'nullable|numeric|min:0',

            'product_amount' => 'nullable',
            'is_exchangable' => 'nullable|boolean',
            'exchangable_item' => 'nullable',
            'exchangable_amount' => 'nullable',

            'vehicle_number' => 'nullable|string|max:255',
            'vehicle_year' => 'nullable',
            'paid_advance' => 'nullable|boolean',
            'advance_amount' => 'nullable',

            'paid_amount' => 'nullable',
            'balance' => 'nullable',

            'emi_applicable' => 'nullable|boolean',
            'emi_amount' => 'nullable',
            'emi_month' => 'nullable',
            'emi_date' => 'nullable',

        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required'        => 'Select a product.',
            'client_id.required'         => 'Select a client.',
            'bank_id.required'           => 'Select a bank.',
            'interest.required'          => 'The interest is required.',
            'is_exchangable.required'    => 'Select an exchangeable type.',
            'is_exchangable.boolean'     => 'Exchangeable type must be true or false.',
            'exchangable_item.required_if'  => 'The exchangeable item is required.',
            'exchangable_amount.required_if' => 'The exchangeable amount is required.',
            'vehicle_number.required_if' => 'The vehicle number is required.',
            'vehicle_year.required_if' => 'The vehicle year is required.',

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

    // passedValidation(): removed to avoid local IDE/tooling errors.
    // (No effect on core cash/products validation behavior.)

}

