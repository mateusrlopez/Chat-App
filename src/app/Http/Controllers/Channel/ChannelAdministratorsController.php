<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\PrivateController;
use App\Models\Channel;

class ChannelAdministratorsController extends PrivateController
{
    public function index(Channel $channel)
    {
        return $channel->administrators;
    }
}
