<?php

namespace App\Http\Requests\Message;

use App\Traits\AuthorizedRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateMessageRequest extends FormRequest
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
            'content' => 'required'
        ];
    }
}
