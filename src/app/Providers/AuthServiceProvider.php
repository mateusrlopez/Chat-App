<?php

namespace App\Providers;

use App\JWT\JWTGuard;
use App\Models\Channel;
use App\Models\FriendshipRequest;
use App\Models\Invite;
use App\Models\Message;
use App\Models\User;
use App\Policies\ChannelPolicy;
use App\Policies\FriendshipRequestPolicy;
use App\Policies\InvitePolicy;
use App\Policies\MessagePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Channel::class => ChannelPolicy::class,
        FriendshipRequest::class => FriendshipRequestPolicy::class,
        Invite::class => InvitePolicy::class,
        Message::class => MessagePolicy::class,
        User::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Auth::extend('jwt', fn($app, $name, array $config) => new JWTGuard(Auth::createUserProvider($config['provider']), $app->make('request')));
    }
}
