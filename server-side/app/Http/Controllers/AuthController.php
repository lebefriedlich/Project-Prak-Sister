<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $messages = [
            'required' => 'Kolom :attribute harus diisi.',
            'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 401,
                'message' => 'Validation error',
                'error' => $validator->errors()
            ], 401);
        }

        // Coba autentikasi dengan Auth::attempt()
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Ambil user yang sudah terautentikasi
            $user = Auth::user();

            // Buat token untuk user tersebut
            $token = $user->createToken('API Token', ['*'], now()->addHour())->plainTextToken;

            return response()->json([
                'status_code' => 200,
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user,
            ], 200);
        } else {
            return response()->json([
                'status_code' => 401,
                'message' => 'Invalid email or password',
            ], 401);
        }
    }

    public function register(Request $request)
    {
        $request->merge([
            'no_hp' => preg_replace('/\+62/', '0',  $request->no_hp)
        ]);

        $messages = [
            'required' => 'Kolom :attribute harus diisi.',
            'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
            'unique' => 'Email sudah terdaftar.',
            'numeric' => 'Kolom :attribute harus berupa angka.',
            'max_digits' => 'Kolom :attribute maksimal 13 digit.'
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'no_hp' => 'required|numeric|max_digits:13',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 401,
                'message' => 'Validation error',
                'error' => $validator->errors()
            ], 401);
        }

        $request->merge(['role' => 'User']);

        User::create($request->all());

        return response()->json([
            'status_code' => 201,
            'message' => 'User created successfully',
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status_code' => 200,
            'message' => 'Logout successful',
        ], 200);
    }
}
