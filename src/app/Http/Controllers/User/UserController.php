<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\PrivateController;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;

class UserController extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(User::class, 'user', ['except' => ['index']]);  
    }

    public function index()
    {
        return User::all();
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return response()->json('', 204);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json('', 204);
    }
}
