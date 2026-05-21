<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    //

    public function register(Request $req){

        $req->validate([
            'name' => 'string|required',
            'password' => 'required|min:6',
            'email' => 'required|email|unique:users'
        ]);

        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => bcrypt($req->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token'=>$token]);

    }


    public function login(Request $req){

        $req->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $login_fields = filter_var($req->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name' ;

        if(!Auth::attempt([$login_fields => $req->login, 'password' => $req->password])){
            return response()->json([
                'message' => 'Invalid Credentials, try again'
            ], 401);
        }

        $token = Auth::user()->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token
        ]);
    }

    public function logout(Request $req){
        $req->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout Successfull'
        ]);
    }
}
