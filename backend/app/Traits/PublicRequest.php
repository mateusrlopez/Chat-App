<?php

namespace App\Traits;

trait PublicRequest
{
    public function authorize()
    {
        return true;
    }
}