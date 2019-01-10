<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuggestionRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'first' => 'max:100',
            'second' => 'max:100',
            'third' => 'max:100'
        ];
    }

    public function messages()
    {
        return [
            '*.max' => 'Maksymalna liczba znaków to 100'
        ];
    }
}
