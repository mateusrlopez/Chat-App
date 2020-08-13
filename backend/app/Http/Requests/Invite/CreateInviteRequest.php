<?php

namespace App\Http\Requests\Invite;

use App\Traits\AuthorizedRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateInviteRequest extends FormRequest
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
            'invited_id' => 'required|exists:users,id|different:'.Auth::id(),
            'expiration' => 'required|date|after_or_equal:today'
        ];
    }
}
