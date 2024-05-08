<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index(){
        return view('login', [
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            $userId = Auth::user()->id;
            Session::put('user_id', $userId);

            if(Auth::user()->role == 'user'){
                return redirect()->intended('/');
            } elseif(Auth::user()->role == 'admin'){
                return redirect()->intended('/admin');
            } elseif(Auth::user()->role == 'store'){
                return redirect()->intended('/store');
            }
        }
        return back()->with('loginError', 'Login failed')->withInput();

    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true
        ]);
    }
}
