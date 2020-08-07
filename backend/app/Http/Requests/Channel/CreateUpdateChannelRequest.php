<?php

namespace App\Http\Requests\Channel;

use App\Traits\AuthorizedRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateChannelRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'present|nullable',
            'private' => 'required|boolean',
            'tags' => 'required|array',
            'tags.*' => 'nullable'
        ];
    }
}
