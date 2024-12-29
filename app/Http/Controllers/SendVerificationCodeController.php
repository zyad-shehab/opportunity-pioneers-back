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
        $request->validate([
            'email' => 'required|email',
            'type' => 'required',
        ]);

        $user = User::where('email', $request->email)->where('type', $request->type)->first();

        if (!$user) {
            return response()->json([
                'message' => '!!!User not found for the given email and type.',
            ], 404);
        }
        // create random code
        $verificationCode = rand(10000, 99999);
        $expiryTime = env('CODE_VERIFICATION_DELAY', 10);

        $user->update([
            'email_verified_code' => $verificationCode,
            'email_verified_code_expiry' => now()->addMinutes($expiryTime),
        ]);

        try {
            Mail::to($request->email)->send(new VerificationCodeMail($verificationCode));
            $mailStatus = 'Success';
        } catch (\Exception $e) {
            // In case of an error while sending the email
            $mailStatus = 'Failed';
        }
        return response()->json([
            'message' => $mailStatus === 'Success' ? 'Verification code sent successfully.' : 'Verification code sent, but email could not be delivered.',
            'data' => [
                'email' => $user->email,
                'type' => $user->type,
                'verification_code' => $verificationCode,
                'verification_code_expiry' => $user->verification_code_expiry,
            ],
        ], 200);
    }
}
