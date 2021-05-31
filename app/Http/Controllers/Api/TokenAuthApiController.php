<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenAuthApiController extends Controller
{
    public function tokenAction(Request $request): JsonResponse
    {
        if (!\Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(
            ['access_token' => $token, 'token_type' => 'Bearer',], Response::HTTP_OK
        );
    }

    public function revokeTokenAction(Request $request): JsonResponse
    {
        /**
         * @var User $user
         */
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json(['success' => true], Response::HTTP_OK);

    }
}
