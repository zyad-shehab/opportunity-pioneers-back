<?php

namespace App\Http\Controllers;

use App\Mail\VerificationCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendVerificationCodeController extends Controller
{
    public function sendVerificationCode(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'type' => 'required',
        ]);

        // Find the user with the given email and type
        $user = User::where('email', $request->email)
            ->where('type', $request->type)
            ->first();

        // If the user does not exist, return an error response
        if (!$user) {
            return response()->json([
                'message' => 'User not found for the given email and type.',
            ], 404);
        }

        // Generate a random verification code and set the expiry time
        $verificationCode = rand(10000, 99999);
        $expiryTime = env('CODE_VERIFICATION_DELAY', 10);

        // Update the user record with the verification code and expiry time
        $user->update([
            'email_verified_code' => $verificationCode,
            'email_verified_code_expiry' => now()->addMinutes($expiryTime),
        ]);

        // Try sending the verification email
        try {
            Mail::to($request->email)->send(new VerificationCodeMail($verificationCode));
            $mailStatus = 'Success';
        } catch (\Exception $e) {
            // Handle email sending failure
            $mailStatus = 'Failed';
        }

        // Return the response
        return response()->json([
            'message' => $mailStatus === 'Success'
                ? 'Verification code sent successfully.'
                : 'Verification code generated, but email could not be delivered.',
            'data' => [
                'email' => $user->email,
                'type' => $user->type,
                'verification_code' => $verificationCode,
                'verification_code_expiry' => $user->email_verified_code_expiry,
            ],
        ], 200);
    }
}
