<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class LoginController extends Controller
{
    // Other methods...
    public function showLoginForm()
    {
        return view('auth.login');
    }



    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (auth()->user()->hasRole('admin')) {
                return redirect()->intended('/admin/dashboard');
            }
            return redirect()->intended('/admin/dboard'); // or wherever non-admins should go
        }

        // Handle login failure
        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ])->withInput();
    }





    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/'); // Or wherever you want to redirect after logout
    }
}
