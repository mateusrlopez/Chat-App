<?php

namespace App\Http\Requests\Channel;

use App\Traits\AuthorizedRequest;
use Illuminate\Foundation\Http\FormRequest;

class AttachUserChannelRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'admin' => 'required|boolean'
        ];
    }
}
