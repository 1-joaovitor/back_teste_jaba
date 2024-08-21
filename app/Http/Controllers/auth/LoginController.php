<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class LoginController extends Controller
{


    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Login Inválido'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('acessToken')->plainTextToken;
        $user->acessToken =  $token;
        return response()->json(
            $user
        , 200);
    }
    public function profile(Request $request)
    {
        return response()->json(Auth::user(), 200);
    }
}
