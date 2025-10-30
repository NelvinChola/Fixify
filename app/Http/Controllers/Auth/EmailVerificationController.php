<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserVerificationMail;
use Illuminate\Support\Str;

class EmailVerificationController extends Controller
{

     // Send verification email with credentials
    public function sendVerificationEmail(User $user)
    {
        try {
            // Generate verification token and temporary password
            $verificationToken = $user->generateVerificationToken();
            $tempPassword = $user->generateTempPassword();
            
            // Create verification URL
            $verificationUrl = route('verification.verify', [
                'id' => $user->id,
                'hash' => $verificationToken,
            ]);

            // Send email
            Mail::to($user->email)->send(new UserVerificationMail($user, $tempPassword, $verificationUrl));

            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to send verification email: ' . $e->getMessage());
            return false;
        }
    }

   //Verify user email
    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        // Check if the hash matches
        if ($user->verification_token !== $hash) {
            return redirect('/login')->with('error', 'Invalid verification link.');
        }

        // Mark email as verified
        $user->markEmailAsVerified();

        return redirect('/login')->with('success', 'Email verified successfully! You can now login with your credentials.');
    }


     // Resend verification email
    public function resend(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->hasVerifiedEmail()) {
            return back()->with('info', 'Email is already verified.');
        }

        $sent = $this->sendVerificationEmail($user);

        if ($sent) {
            return back()->with('success', 'Verification email sent successfully!');
        }

        return back()->with('error', 'Failed to send verification email. Please try again.');
    }
}