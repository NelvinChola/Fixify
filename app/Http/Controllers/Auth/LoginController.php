<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Check if user exists and is verified before attempting login
    $user = User::where('email', $request->email)->first();

    if ($user) {
        // Check if email is verified
        if (!$user->hasVerifiedEmail()) {
            return back()->with([
                'unverified' => 'Please verify your email address before logging in. Check your email for the verification link.',
                'unverified_email' => $user->email
            ])->withInput($request->only('email', 'remember'));
        }

        // Check if user has temporary password (for first-time login)
        // if ($user->hasTempPassword()) {
        //     // Allow login but we'll handle the temp password redirect after auth
        // }
    }

    if (auth()->attempt($credentials)) {
        $request->session()->regenerate();
      
        $user = auth()->user();
        
        // Check if user needs to change temporary password
        // if ($user->hasTempPassword()) {
        //     return redirect()->route('password.change')
        //         ->with('warning', 'Please change your temporary password for security reasons.');
        // }

        // Redirect to welcome dashboard instead of direct pages
        return redirect()->route('dashboard.welcome');

        // $allowedRoles = ['Technician', 'HelpDesk', 'Admin'];

        // if (in_array($user->role->name, $allowedRoles)) {
        //     return redirect()->route('JobCard.index');
        // } else {
        //     return redirect()->route('service-requests.select-device');
        // }
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->withInput($request->only('email', 'remember'));
}
}