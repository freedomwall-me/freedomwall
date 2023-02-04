<?php

namespace App\Http\Controllers\Auth;

use App\Http\HttpResponse;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller as BaseController;

class AuthenticationController extends BaseController
{
    use HttpResponse;

    public function __construct()
    {
        $this->middleware('auth:sanctum', ['only' => ['logout']]);
    }

    public function login(LoginUserRequest $request)
    {
        $request->validated();

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return $this->error('Invalid credentials.', [], 400);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->success('Logged in successfully.', [
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout()
    {
        auth('sanctum')->user()->tokens()->delete();

        return $this->success('Logged out successfully.');
    }

    public function register(StoreUserRequest $request)
    {
        $request->validated();

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->save();

        return $this->success('Created user successfully.', [
            'user' => $user
        ]);
    }
}
