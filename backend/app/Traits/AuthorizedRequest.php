<?php

namespace App\Traits;

trait AuthorizedRequest
{
    public function authorize()
    {
        return true;
    }
}