<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);


        if (Auth::attempt($request->only('username', 'password'))) {
            $user = Auth::user();
            $roles = $user->getRoleNames()->toArray();
            $data = [
                'token' => $user->createToken('API Token')->plainTextToken,
                'id' => $user->id,
                'nama' => $user->name,
                'role' => $roles[0]
            ];

            return response()->json([
                'success' => true,
                'message' => 'Login Berhasil',
                'data' => $data,
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Kredensial yang diberikan salah.',
                'data' => null,
            ]);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out.',
        ]);
    }
}
