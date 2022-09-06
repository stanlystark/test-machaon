<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class CheckCodeRequest extends FormRequest
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
            'code' => 'required|exists:links',
        ];
    }


    public function messages()
    {
        return [
            'code.required' => 'Требуется ссылка',
            'code.exists' => 'Кода не существует :(',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        return throw new ValidationException($validator, (new JsonResponse($validator->errors())));
    }
}
