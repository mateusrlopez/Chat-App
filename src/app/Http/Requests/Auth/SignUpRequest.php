<?php

namespace App\Http\Requests\Auth;

use App\Traits\AuthorizedRequest;
use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
{
    use AuthorizedRequest;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users',
            'name' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ];
    }
}
