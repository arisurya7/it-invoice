<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('login.index');
    }

    public function authenticate(Request $request){
        $rules = [
            'username'=>'required',
            'password'=>'required',
        ];
        $errMessage = [
            'username.required'=>'Username wajib diisi',
            'password.required'=>'Passoword wajib diisi'
        ];
        $credentials = $request->validate($rules, $errMessage);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->with('loginError', 'Username atau Password Salah!');

    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Anda berhasil logout');
    }
}
