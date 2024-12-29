<?php

namespace App\Http\Controllers;

use App\Mail\VerificationCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class sendVerificationCodeController extends Controller
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
        $verification_code = rand(10000, 99999);
        $expiryTime = env('CODE_VERIFICATION_DELAY', 10);
        
        $user->update([
            'verification_code' => $verification_code,
            'verification_code_expiry' => now()->addMinutes($expiryTime),
        ]);

        Mail::to($request->email)->send(new VerificationCodeMail($verification_code));

        return response()->json([
            'message' => 'Verification code sent successfully.',
            'data' => [
                'email' => $user->email,
                'type' => $user->type,
                'verification_code' => $verification_code,
                'verification_code_expiry' => $user->verification_code_expiry, 
                ], 
        ], 200);
    }
}
