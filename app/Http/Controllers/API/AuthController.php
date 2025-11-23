<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        /** @var \App\Models\User $user */
        $user = $request->user();

        if (!method_exists($user, 'createToken')) {
            return response()->json(['message' => 'Sanctum no instalado todavía'], 500);
        }

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }
        return response()->json([], 204);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string','min:6'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'customer',
        ]);

        if (!method_exists($user, 'createToken')) {
            return response()->json(['message' => 'Sanctum no instalado todavía'], 500);
        }

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ], 201);
    }

    public function me(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
        ]);
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => ['required','string'],
            'new_password' => ['required','string','min:6'],
        ]);

        /** @var User $user */
        $user = $request->user();
        if (!Hash::check($data['current_password'], $user->password)) {
            return response()->json([
                'message' => 'La contraseña actual no coincide'
            ], 422);
        }

        $user->password = $data['new_password']; // Cast "hashed" maneja el hash
        $user->save();

        return response()->json([
            'message' => 'Contraseña actualizada correctamente'
        ], 200);
    }
}
