<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\VerifyCodeRequest;
use App\Models\Country;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendVerificationCode;
use Exception;
use App\Http\Requests\ForgetPasswordRequest;
use App\Mail\ResetPasswordMail;
use App\Models\PasswordResetToken;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponses;

    public function __construct(private SendVerificationCode $sendVerificationCode) {}

    public function verifyCode(VerifyCodeRequest $request)
    {
        $request->validated($request->all());
        // Retrieve the user by email and type
        $user = User::where('email', $request->email)
            ->where('type', $request->type)
            ->first();

        if (!$user) {
            return $this->error('User not found.', 404);
        }
        // Validate the verification code and check if it is still valid
        if (
            $user->email_verified_code !== $request->code ||
            now()->greaterThan($user->email_verified_code_expiry)
        ) {
            return $this->error('Invalid or expired verification code.', 400);
        }
        // Update user status to active
        $user->update([
            'status' => User::ACTIVE,

        ]);
        return $this->success('User verified successfully.', [
            'email' => $user->email,
            'type' => $user->type,
        ], 200);
    }

    /**
     * User login
     */
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        // Retrieve the user with matching email and type  to allow the user login with more than one type with same email
        $user = User::where('email', $validated['email'])
            ->where('type', $validated['type'])
            ->first();
        // Check if the user exists and the password matches
        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return $this->error('Login information invalid', 401);
        }

        // Check if the user is active
        if ($user->status !== User::ACTIVE) {
            return $this->error('Your account is not activated. Please verify your email.', 403);
        }

        // If authentication is successful, generate and return an access token
        return $this->success(
            'Authenticated',
            [
                'email' => $user->email,
                'type' => $user->type,
                'token' => $user->createToken('L_Token')->plainTextToken,
                'token_type' => 'Bearer',
            ],
            200,
        );
    }
    /**
     * Register a new user.
     */
    public function register(RegisterRequest $request)
    {
        // Validate incoming request
        $validated = $request->validated();
        $userArray = [
            'name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'type' => $validated['type'],
            'status' => User::INACTIVE, // Initial status
            'username' => $validated['type'] . '_' . $validated['email'],
        ];
        if (in_array($validated['type'], ['employer', 'supporting-initiative'])) {
            $country = Country::where('name_en', $request->country)->first();
            $userArray['country_id'] = $country->id;
        }
        // Create the user
        $user = User::create($userArray);

        try {
            // Send verification code
            $this->sendVerificationCode->sendEmail($user);
            // Return success response
            return $this->success('User registered successfully.', [
                'user' => $user,
            ], 201);
        } catch (Exception $exception) {
            // Roll back user creation if email sending fails
            $user->delete();
            return $this->error('Registration failed. Please try again later.', 403);
        }
    }
    /**
     * Forget Password
     */

    public function forgetPassword(forgetPasswordRequest $request)
    {
        $validated = $request->validated();
        $user = User::where('email', $validated['email'])
            ->where('type', $validated['type'])
            ->first();

        if (!$user) {
            return $this->error('User not found.', 404);
        }

        // Generate a password reset token
        $token = Str::random(64);
        $resetToken = PasswordResetToken::where('email', $user->email)
            ->where('type', $user->type)
            ->first();

        if ($resetToken) {
            // Update the existing token if the user dose not make reset for password
            $updated =  $resetToken->update([
                'token' => $token,
                'created_at' => now(),
            ]);
            if (!$updated) {
                return $this->error('Failed to update reset token.', 500);
            }
        } else {
            // Create a new record if it doesn't exist
            $created = PasswordResetToken::create([
                'email' => $user->email,
                'type' => $user->type,
                'token' => $token,
                'created_at' => now(),
            ]);
            if (!$created) {
                return $this->error('Failed to create reset token.', 500);
            }
        }
        try {
            Mail::to($user->email)->send(new ResetPasswordMail($token, $user->email));
            return $this->success(
                'Password reset and email sent successfully.',
                [
                    "email" => $user->email,
                    "token" => $token
                ],
                200
            );
        } catch (Exception $e) {
            return $this->error('Failed to send email. Please try again later.', 400);
        }
    }

    /**
     * Reset Password
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $validated = $request->validated();
        $tokenRecord = PasswordResetToken::where('email', $validated['email'])
            ->where('type', $validated['type'])
            ->first();
        if (!$tokenRecord) {
            return $this->error('Invalid token.', 400);
        }
        $user = User::where('email', $validated['email'])
            ->where('type', $validated['type'])
            ->first();
        if (!$user) {
            return $this->error('User not found.', 404);
        }
        $user->password = Hash::make($validated['new_password']);
        $user->save();
        $tokenRecord->delete();
        return $this->success('Password reset successfully.', ["email" => $user->email], 200);
    }


    /**
     * Change Password
     */

    public function changePassword(ChangePasswordRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();
        if (!Hash::check($validated['password'], $user->password)) {
            return $this->error('Current password is incorrect.', 400);
        }
        try {
            $user->password = Hash::make($validated['new-password']);
            $user->save();
            return $this->success('Password changed successfully.', [
                'email' => $user->email,
                'type' => $user->type,
            ], 200);
        } catch (Exception $e) {
            return $this->error('Failed to update the password. Please try again later.', 500);
        }
    }
}
