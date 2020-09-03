<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::get('/logout', 'Auth\AuthController@logout');
    Route::post('/login', 'Auth\AuthController@login');
    Route::post('/sign-up', 'Auth\AuthController@signUp');
    Route::post('/request-password-reset', 'Auth\PasswordController@requestPasswordReset');
    Route::post('/reset-password', 'Auth\PasswordController@resetPassword');
});

Route::apiResource('channels', 'Channel\ChannelController');
Route::apiResource('channels.messages', 'Channel\ChannelMessageController')->only(['index', 'store']);
Route::apiResource('channels.invites', 'Channel\ChannelInviteController')->only(['index', 'store']);
Route::apiResource('channels.users', 'Channel\ChannelUserController')->except('show');
Route::apiResource('users', 'User\UserController')->except(['store', 'show']);
Route::apiResource('users.channel', 'User\UserChannelController')->only('index');
Route::apiResource('users.invites-received', 'User\UserInviteReceivedController')->only('index');
Route::apiResource('users.friends', 'User\UserFriendController')->only(['index', 'destroy']);
Route::apiResource('users.friendship-requests-sent', 'User\UserFriendshipRequestSentController')->only('store');
Route::apiResource('users.friendship-requests-received', 'User\UserFriendshipRequestReceivedController')->only('index');
Route::apiResource('friendship-requests', 'FriendshipRequest\FriendshipRequestController')->only('destroy');
Route::put('friendship-requests/{friendship_request}/accept', 'FriendshipRequest\FriendshipRequestController@accept');
Route::apiResource('messages', 'Message\MessageController')->only(['update', 'destroy']);
Route::apiResource('invites', 'Invite\InviteController')->only('destroy');
Route::put('invites/{invite}/accept', 'Invite\InviteController@accept');