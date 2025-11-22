<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginView()
    {
        // If already authenticated, go straight to dashboard
        if (Auth::check()) {
            return redirect('/network-status');
        }

        return view('components.auth_component.login', [
            'title' => 'Login',
            'appName' => 'Healthkathon Admin',
        ]);
    }

    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Use env variables so you can change credentials without editing code
        $adminEmail = env('ADMIN_EMAIL', 'admin@gmail.com');
        $adminPassword = env('ADMIN_PASSWORD', 'admin123');

        if ($request->input('email') === $adminEmail && $request->input('password') === $adminPassword) {
            $remember = $request->boolean('remember', true);
            Auth::loginUsingId(1, $remember);
            $request->session()->regenerate();
            return redirect('/network-status')->with('success', 'Login successful!');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Logout successful!');
    }
}
