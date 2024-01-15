<?php

namespace App\Http\Requests\Seller\Service;

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
            'category_id'                   => 'required',
            'subcategory_id'                => 'required',
            'child_category_id'             => 'required',
            'seller_id'                     => 'nullable',
            'service_city_id'               => 'required',
            'title'                         => 'required|string',
            'slug'                          => 'required|string',
            'description'                   => 'required|string',
            'image'                         => 'required|mimes:png,jpg',
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
