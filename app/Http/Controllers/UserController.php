<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        // Mengambil semua data user dengan relasi role
        return User::with('role')->get();
    }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $data = $request->validate(
                [
                    'nama' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:6',
                    'role_id' => 'required|exists:roles,id',
                    'nomor_handphone' => 'nullable|string',
                    'alamat' => 'nullable|string',
                ],
                [
                    'nama.required' => 'Nama harus diisi.',
                    'email.required' => 'Email harus diisi.',
                    'email.unique' => 'Email sudah digunakan.',
                    'password.required' => 'Password harus diisi.',
                    'role_id.required' => 'Role harus dipilih.',
                    'role_id.exists' => 'Role yang dipilih tidak valid.',
                    'nomor_handphone.string' => 'Nomor handphone harus berupa string.',
                    'alamat.string' => 'Alamat harus berupa string.',
                ]
            );
            // Hash password sebelum menyimpan ke database
            $data['password'] = Hash::make($data['password']);

            // Buat user baru
            $user = User::create($data);
            return response()->json([
                'message' => 'User berhasil ditambahkan.',
                'data' => $user
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function show($id)
    {
        // Menampilkan detail user berdasarkan ID dengan relasi role
        return User::with('role')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        // Mencari user berdasarkan ID
        $user = User::findOrFail($id);
        try {
            // Validasi input untuk update user
            $data = $request->validate(
                [
                    'nama' => 'sometimes|string|max:255',
                    'email' => 'sometimes|email|unique:users,email,' . $id,
                    'password' => 'sometimes|string|min:6',
                    'role_id' => 'sometimes|exists:roles,id',
                    'nomor_handphone' => 'sometimes|string',
                    'alamat' => 'sometimes|string',
                ],
                [
                    'nama.string' => 'Nama harus berupa string.',
                    'email.email' => 'Email harus berupa alamat email yang valid.',
                    'email.unique' => 'Email sudah digunakan.',
                    'password.string' => 'Password harus berupa string.',
                    'password.min' => 'Password minimal 6 karakter.',
                    'role_id.exists' => 'Role yang dipilih tidak valid.',
                    'nomor_handphone.string' => 'Nomor handphone harus berupa string.',
                    'alamat.string' => 'Alamat harus berupa string.',
                ]
            );
            // Jika password diberikan, hash password sebelum menyimpan
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }
            // Update user dengan data yang sudah divalidasi
            $user->update($data);
            return response()->json([
                'message' => 'User berhasil diperbarui.',
                'data' => $user
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function destroy($id)
    {
        // Mencari user berdasarkan ID
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User berhasil dihapus.']);
    }
}
