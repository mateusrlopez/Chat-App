<?php

namespace App\Http\Requests\Auth;

use App\Traits\PublicRequest;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    use PublicRequest;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email|exists:password_resets',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ];
    }
}
