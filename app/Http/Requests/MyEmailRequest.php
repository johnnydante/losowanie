<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MyEmailRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email,'.Auth::id(),
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Musisz podać jakiś e-mail',
            'email.email' => 'Podany e-mail jest nieprawidłowy',
            'email.unique' => 'Podany e-mail już jest w bazie',
        ];
    }
}
