<?php

namespace App\Http\Requests\Buyer\Post;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
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
            'category_id'       => 'nullable',
            'subcategory_id'    => 'nullable',
            'childCategory_id'  => 'nullable',
            'country_id'        => 'nullable',
            'city_id'           => 'nullable',
            'buyer_id'          => 'nullable',
            'title'             => 'nullable',
            'description'       => 'nullable',
            'budget'            => 'nullable',
            'dead_line'         => 'nullable|date',
            'image'             => 'nullable',
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
