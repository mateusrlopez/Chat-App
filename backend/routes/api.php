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
Route::apiResource('users.invites', 'User\UserInviteController')->only('index');
Route::apiResource('messages', 'Message\MessageController')->only(['update', 'destroy']);
Route::apiResource('invites', 'Invite\InviteController')->only('destroy');
Route::group(['prefix' => 'invites/{invite}'], function() {
    Route::put('accept', 'Invite\InviteController@accept');
});