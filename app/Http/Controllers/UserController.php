<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function loginView(){
        return view('login');
    }

    public function registerView(){
        return view('register');
    }

    public function loginMethod(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator->errors())->withInput();
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $request->session()->regenerate();
            $token = Auth::user()->createToken('UserToken')->accessToken;
            return redirect()->route('dashboard')->withCookie(cookie('access_token', $token, 30));
        } else {
            return back()->withErrors('errors', 'Invalid Email or Password');
        }
    }

    public function registerMethod(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'password_confirm' => 'required|same:password',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'password_confirm' => $request->password_confirm,
        ];

        User::create($data);

        return redirect()->route('login')->with('success', 'Register Success');
    }

    public function logout(){
        Auth::logout();
        Cookie::queue(Cookie::forget('access_token'));
        return redirect()->route('login')->with('success', 'logout success');
    }
}
