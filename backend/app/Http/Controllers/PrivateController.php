<?php

namespace App\Http\Controllers;

class PrivateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}
