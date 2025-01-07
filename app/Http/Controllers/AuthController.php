<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Country;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\SendVerificationCodeController;

class AuthController extends Controller
{
    use ApiResponses;

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
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return $this->error('Login information invalid', 401);
        }

        // Check if the user is active
        if ($user->status !== 'active') {
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
            'status' => 'inactive', // Initial status
            'username' => $validated['type'] . '_' . $validated['email'],
        ];
        if (in_array($validated['type'], ['employer', 'supporting-initiative'])) {
            $country = Country::where('name_en', $request->country)->first();
            $userArray['country_id'] = $country->id;
        }
        // Create the user
        $user = User::create($userArray);

        // Send verification code
        $sendVerificationResponse = app(SendVerificationCodeController::class)->sendVerificationCode(new \Illuminate\Http\Request([
            'email' => $user->email,
            'type' => $user->type,
        ]));
        $emailSent = $sendVerificationResponse->getStatusCode() === 200;

        return $this->success('User registered successfully.', [
            'user' => $user,
            'email_status' => $emailSent ? 'Verification email sent successfully.' : 'Failed to send verification email.',
        ], 201);
    }
}
