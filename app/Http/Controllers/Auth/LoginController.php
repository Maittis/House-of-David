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
            /** @var \App\Models\User $user */
            $user = auth()->user();
            if ($user->hasRole('superadmin')) {
                return redirect()->intended('/superadmin/dashboard');
            }
            if ($user->hasRole('admin')) {
                return redirect()->intended('/admin/dashboard');
            }
            if ($user->hasRole('usher')) {
                return redirect()->intended('/usher/dashboard');
            }
            // Default redirect for other roles or no role
            return redirect()->intended('/home');
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
