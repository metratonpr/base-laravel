<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Generate a Sanctum token for the user.
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::query()->where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        $tokenName = $credentials['device_name'] ?? $request->userAgent() ?? 'api-client';
        $abilities = $user->getAllPermissions()->pluck('name')->all();

        $token = $user->createToken($tokenName, $abilities);

        return response()->json([
            'token' => $token->plainTextToken,
            'token_type' => 'Bearer',
            'abilities' => $abilities,
            'user' => UserResource::make($user->loadMissing(['roles', 'permissions'])),
        ], 201);
    }

    /**
     * Revoke the current access token.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json(null, 204);
    }

    /**
     * Return the authenticated user details.
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'user' => UserResource::make($request->user()->loadMissing(['roles', 'permissions'])),
        ]);
    }
}
