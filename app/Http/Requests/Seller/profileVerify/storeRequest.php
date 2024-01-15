<?php

namespace App\Http\Requests\Seller\profileVerify;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class storeRequest extends FormRequest
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
            'many_employee_id'       => 'required',
            'professional_status_id' => 'required',
            'gisa'                   => 'nullable',
            'company_name'           => 'required',
            'address'                => 'required',
            'zip_code'               => 'required',
            'busines_license'        => 'required|mimes:png,jpg',
            'seller_id'              => 'nullable',
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors(),
        ], 422));
    }
}
