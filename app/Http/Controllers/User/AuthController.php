<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function getToken(LoginRequest $request): JsonResponse
    {
        if (!auth()->attempt($request->validated()))
            abort(401, __('auth.failed'));

        /** @var User $user */
        $user = auth()->user();

        return response()->json([
            'token' => $user->createToken('api')->plainTextToken,
            'type' => 'Bearer'
        ]);
    }
}
