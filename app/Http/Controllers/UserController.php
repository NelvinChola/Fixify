<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Role;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Auth\EmailVerificationController;
use Illuminate\Support\Str;
use App\Mail\UserVerificationMail; // Add this import

class UserController extends Controller
{
public function __construct()
    {
    //     $this->middleware('auth');
    //     $this->middleware('can:manage-users');
    }

    public function index()
    {
        $users = User::with('role')->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'contact' => 'required|string|max:20',
        'nrc' => 'nullable|string|max:50',
        'address' => 'nullable|string|max:255',
        'role_id' => 'required|exists:roles,id',
    ]);

    try {
        // Create user with minimal fields first
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'nrc' => $request->nrc,
            'address' => $request->address,
            'role_id' => $request->role_id,
        ]);

        // Use your model method to generate temporary password
        $tempPassword = $user->generateTempPassword();
        
        // Update the password field with the hashed temporary password
        $user->update([
            'password' => Hash::make($tempPassword)
        ]);

        // Use your model method to generate verification token
        $verificationToken = $user->generateVerificationToken();
        
        // Create verification URL using the generated token
        $verificationUrl = route('verification.verify', [
            'id' => $user->id,
            'hash' => $verificationToken,
        ]);

        $emailSent = false;
        $message = 'User created successfully!';

        // ALWAYS send verification email (remove the condition)
        try {
            Mail::to($user->email)->send(new UserVerificationMail($user, $tempPassword, $verificationUrl));
            $emailSent = true;
            $message .= ' Verification email with login credentials has been sent.';
        } catch (\Exception $emailException) {
            \Log::error('Failed to send verification email: ' . $emailException->getMessage());
            $message .= ' However, failed to send verification email. You can resend it later.';
        }

        return redirect()->route('users.index')
            ->with($emailSent ? 'success' : 'warning', $message);

    } catch (\Exception $e) {
        \Log::error('User creation failed: ' . $e->getMessage());
        
        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to create user: ' . $e->getMessage());
    }
}

    // Method to resend verification email for existing users
    public function resendVerification($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Check if user already verified using your model
            if ($user->email_verified_at) {
                return redirect()->back()->with('info', 'User email is already verified.');
            }

            // Use your model method to generate new verification token
            $verificationToken = $user->generateVerificationToken(); // This automatically saves
            
            // Create verification URL
            $verificationUrl = route('verification.verify', [
                'id' => $user->id,
                'hash' => $verificationToken,
            ]);

            // Use your model method to check if user has temp password
            if (!$user->hasTempPassword()) {
                // Generate new temporary password using your model method
                $tempPassword = $user->generateTempPassword(); // This saves automatically
            } else {
                // Use existing temporary password
                $tempPassword = $user->temp_password;
            }

            // Send verification email
            Mail::to($user->email)->send(new UserVerificationMail($user, $tempPassword, $verificationUrl));
            
            return redirect()->back()->with('success', 'Verification email sent successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Resend verification failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to resend verification email: ' . $e->getMessage());
        }
    }

    // Method to manually send verification email (for users created without email)
    public function sendVerificationEmail($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Check if user already verified using email_verified_at
            if ($user->email_verified_at) {
                return redirect()->back()->with('info', 'User email is already verified.');
            }

            // Use your model method to generate verification token if none exists
            if (!$user->verification_token) {
                $user->generateVerificationToken(); // This saves automatically
                $user->refresh(); // Refresh to get the new token
            }

            // Create verification URL
            $verificationUrl = route('verification.verify', [
                'id' => $user->id,
                'hash' => $user->verification_token,
            ]);

            // Use your model method to check and generate temp password if needed
            if (!$user->hasTempPassword() || !$user->temp_password) {
                $tempPassword = $user->generateTempPassword(); // This saves automatically
            } else {
                $tempPassword = $user->temp_password;
            }

            // Send verification email
            Mail::to($user->email)->send(new UserVerificationMail($user, $tempPassword, $verificationUrl));
            
            return redirect()->back()->with('success', 'Verification email sent successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Send verification email failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to send verification email: ' . $e->getMessage());
        }
    }

    // Verification endpoint that uses your markEmailAsVerified method
    public function verifyEmail($id, $hash)
    {
        try {
            $user = User::findOrFail($id);

            // Check if the hash matches
            if ($user->verification_token !== $hash) {
                return redirect('/login')->with('error', 'Invalid verification link.');
            }

            // Use your model method to mark email as verified
            $user->markEmailAsVerified(); // This sets email_verified_at and clears verification_token

            return redirect('/login')->with('success', 'Email verified successfully! You can now login with your credentials.');

        } catch (\Exception $e) {
            \Log::error('Email verification failed: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Email verification failed. Please try again.');
        }
    }
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
    'contact' => 'required|string|max:255',
    'nrc' => 'nullable|string|max:255',
    'address' => 'nullable|string|max:255',
    'password' => ['nullable', 'confirmed', Password::defaults()],
    'role_id' => 'required|exists:roles,id',
]);


        $data = [
          'name' => $request->name,
          'email' => $request->email,
          'role_id' => $request->role_id,
          'contact' => $request->contact,
          'nrc' => $request->nrc,
          'address' => $request->address,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')
                         ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
                         ->with('success', 'User deleted successfully.');
    }
}
