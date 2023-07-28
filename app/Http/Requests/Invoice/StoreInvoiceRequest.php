<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'date' => ['required'],
            'status' => ['required', 'in:completed,pending,failed'],
            'amount' => ['required', 'numeric'],
            'method' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'is_pay' => ['required']
        ];
    }
}
