<?php

namespace App\Providers;

use App\Models\FriendshipRequest;
use App\Models\Invite;
use App\Observers\FriendshipRequestObserver;
use App\Observers\InviteObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        FriendshipRequest::observe(FriendshipRequestObserver::class);
        Invite::observe(InviteObserver::class);
    }
}
