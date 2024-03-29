<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
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
            'Name'=>['nullable','string'],
            'Date'=>['nullable'],
            'Status'=>['nullable','in:completed,pending,failid'],
            'Amount'=>['nullable','numeric'],
            'Method'=>['nullable','string'],
            'Description'=>['nullable','string']
        ];
    }
}
