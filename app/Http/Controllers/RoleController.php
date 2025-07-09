<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
    public function index()
    {
        return Role::all();
    }

    public function store(Request $request)
    {
        try {

            $data = $request->validate(
                [
                    'nama_role' => 'required|string|unique:roles,nama_role',
                    'deskripsi' => 'nullable|string',
                    'is_active' => 'boolean'
                ],
                [
                    'nama_role.required' => 'Nama role harus diisi.',
                    'nama_role.unique' => 'Nama role sudah digunakan.',
                    'is_active.boolean' => 'Status aktif harus berupa boolean.'
                ]
            );

            $role = Role::create($data);
            return response()->json([
                'message' => 'Role berhasil ditambahkan.',
                'data' => $role
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function show($id)
    {
        return Role::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        try {

            $data = $request->validate([
                'nama_role' => 'required|string|unique:roles,nama_role,' . $id,
                'deskripsi' => 'nullable|string',
                'is_active' => 'boolean'
            ]);

            $role->update($data);
            return response()->json([
                'message' => 'Role berhasil diperbarui.',
                'data' => $role
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return response()->json(['message' => 'Role berhasil dihapus.'], 200);
    }
}
