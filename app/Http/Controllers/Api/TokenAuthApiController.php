<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class TokenAuthApiController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function generateToken(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request['email'])->firstOrFail();

        if (! $user || ! Hash::check($request->get('password'), $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('bearerToken')->plainTextToken;

        return response()->json(
            ['success' => true, 'token' => $token, 'type' => 'Bearer',], Response::HTTP_OK
        );
    }

    public function revokeToken(Request $request): JsonResponse
    {
        /**
         * @var User $user
         */
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json(['success' => true], Response::HTTP_OK);

    }

    public function currentUser(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }
}
