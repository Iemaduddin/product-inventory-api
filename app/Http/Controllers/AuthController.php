<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input 
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // Cek apakah user ada dan password cocok
        $user = User::where('email', $request->email)->first();
        // Jika user tidak ditemukan atau password tidak cocok, lemparkan exception
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(['email' => ['Email atau password Anda salah!']]);
        }
        // Buat token untuk user
        $token = $user->createToken('api-token')->plainTextToken;
        // Kembalikan token dan informasi user
        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }
    public function me(Request $request)
    {
        // Kembalikan informasi user yang sedang login
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        // Hapus token akses yang sedang digunakan
        $request->user()->currentAccessToken()->delete();
        // Kembalikan respons sukses
        return response()->json(['message' => 'Berhasil logout']);
    }
}
