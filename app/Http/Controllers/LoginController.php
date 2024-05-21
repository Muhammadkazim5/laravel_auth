<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function authenticate(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validate->passes()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('acoount.dashboard');
            } else {
                return redirect()->route('acoount.login')->with('error', 'Either Email or Password in Incorrrect!');
            }
        } else {
            return redirect()->route('acoount.login')->withInput()->withErrors($validate);
        }
    }
    public function register()
    {
        return view('register');
    }
    public function registerauth(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5',
            'password_confirmation' => 'required',
        ]);
        if ($validate->passes()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'customer';
            $user->save();
            return redirect()->route('acoount.login')->with('success', 'you have registered successfully');
        } else {
            return redirect()->route('acoount.register')->withInput()->withErrors($validate);
        }

    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('acoount.login');
    }

}
