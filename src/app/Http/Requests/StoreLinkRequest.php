<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class StoreLinkRequest extends FormRequest
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
            'url' => 'required|min:5|url',
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'url.required' => 'Требуется ссылка',
            'url.min' => 'Ссылка слишком короткая',
            'url.url' => 'Ссылка не действительна',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        return throw new ValidationException($validator, (new JsonResponse(['errors' => $validator->errors()])));
    }
}
