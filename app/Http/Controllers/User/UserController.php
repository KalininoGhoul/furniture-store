<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\SignUpRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function store(SignUpRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::query()->create($request->validated());

        return response()->json([
            'token' => $user->createToken('api')->plainTextToken,
            'type' => 'Bearer'
        ]);
    }
}
