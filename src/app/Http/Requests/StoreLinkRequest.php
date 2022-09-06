<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'url' => 'required|min:5',
        ];
    }


    public function messages()
    {
        return [
            'url.required' => 'Требуется ссылка',
            'url.min' => 'Ссылка слишком короткая',
        ];
    }
}
