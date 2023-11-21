<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\ResponseHandlerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ResponseHandlerTrait;

    public function register(StoreUserRequest $request)
    {
        $request->validated($request->all());

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return $this->successResponse([
            'user' => $user,
            'token' => $user->createToken('api token of ' . $user->name)->plainTextToken
        ], 'User registered successfully.');
    }

    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return $this->errorResponse('Credentials do not match', 401);
        }

        $user = User::where('email', $request->email)->first();

        return $this->successResponse([
            'user' => $user,
            'token' => $user->createToken('API token of ' . $user->name . '.')->plainTextToken
        ], "Successfully authenticated.");
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->successResponse(null,
            'Successfully logged out.'
        );
    }
}
