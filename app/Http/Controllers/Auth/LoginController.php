<?php

namespace App\Http\Controllers\Auth;

use App\Actions\LoginUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\AuthResource;
use App\Http\Resources\ErrorResource;
use Exception;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{

    public function login(LoginRequest $request, LoginUserAction $loginUserAction): ErrorResource|AuthResource
    {
        try {
            $user = $loginUserAction($request->input('email'), $request->input('password'));
        } catch (Exception $e) {
            return new ErrorResource($e->getMessage(), null, 401);
        }

        $user->tokens()->delete();
        $token = $user->createToken('auth')->plainTextToken;

        return new AuthResource("Login exitoso", $token, $user);
    }

    public function logout(UserRequest $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente',
        ]);
    }
}
