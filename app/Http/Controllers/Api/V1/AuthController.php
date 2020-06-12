<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\LoginResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login User
     *
     * @param LoginRequest $request
     * @return LoginResource|JsonResponse
     */
    public function login(LoginRequest $request)
    {
        // Check user
        $user = User::query()->where('email', $request->email)->firstOrFail();
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => ['password' => ['Mot de passe invalide']]
            ]);
        }

        return new LoginResource($user);
    }
}
