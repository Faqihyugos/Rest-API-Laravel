<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:20',
            'email' => 'required|string|email|max:30|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validate->fails()) {
            return ResponseFormatter::error($validate->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return ResponseFormatter::success($user, 'Register successfully', 201);

    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|string|email|max:30',
            'password' => 'required|string|min:8',
        ]);

        if ($validate->fails()) {
            return ResponseFormatter::error($validate->errors(), 400);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {  
            return ResponseFormatter::error(null, 'Invalid credentials', 401);
        }

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Login successfully'
            ],
            'data' => $user,
            'token' => $user->createToken('authToken')->accessToken
        ]);

    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'success' => true,
            'message' => 'Logout successfully'
        ]);
    }
}
