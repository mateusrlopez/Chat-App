<?php

namespace App\Http\Requests\FriendshipRequest;

use App\Rules\FriendId;
use App\Traits\AuthorizedRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateFriendshipRequestRequest extends FormRequest
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
            'receiver_id' => ['required', 'exists:users,id', new FriendId()]
        ];
    }
}
