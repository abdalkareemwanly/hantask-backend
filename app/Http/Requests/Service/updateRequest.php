<?php

namespace App\Http\Requests\Service;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class updateRequest extends FormRequest
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
            'category_id'                   => 'nullable',
            'subcategory_id'                => 'nullable',
            'child_category_id'             => 'nullable',
            'seller_id'                     => 'nullable',
            'service_city_id'               => 'nullable',
            'title'                         => 'nullable|string',
            'slug'                          => 'nullable|string',
            'description'                   => 'nullable|string',
            'image'                         => 'nullable|mimes:png,jpg',
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
