<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginApiController extends Controller {

    public function login(Request $request){
        $login = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if(!Auth::attempt($login)){
            $msg = 'Invalid Credentials';
            return response()->json($msg);
        }

        $accessToken = Auth::user()->createToken('accessToken')->accessToken;
        return response()->json([
            'user' => Auth::user(),
            'access_token' => $accessToken
        ]);
    }

    public function users(){
        $users = User::all();
        return response()->json($users);
    }

    public function index(){
        return response()->json('test');
    }
}
