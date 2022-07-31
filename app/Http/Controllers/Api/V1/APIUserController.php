<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class APIUserController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors(),
            ], 422);
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            return response()->json([
                'message' => 'Login Success',
                'token' => $user->createToken('UserToken')->accessToken,
            ]);
        } else {
            return response()->json([
                'message' => 'Wrong Email or Password',
            ]);
        }
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'password_confirm' => 'required|same:password',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors(),
            ], 422);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'password_confirm' => $request->password_confirm,
        ];

        $user = User::create($data);

        if($user){
            $token = $user->createToken('UserToken')->accessToken;
            return response()->json([
                'message' => 'Register Success',
                'token' => $token,
            ]);
        }
    }

    public function profile(Request $request){
        return response()->json([
            'message' => 'Request Success',
            'data' => $request->user(),
        ]);
    }
}
