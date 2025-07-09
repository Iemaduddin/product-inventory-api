<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LokasiController extends Controller
{
    public function index()
    {
        // Mengambil semua data lokasi dari database
        return Lokasi::all();
    }

    public function store(Request $request)
    {
        try {
            // Validasi input untuk membuat lokasi baru
            $validated = $request->validate(
                [
                    'kode_lokasi' => 'required|unique:lokasis',
                    'nama_lokasi' => 'required',
                    'pic' => 'nullable|string',
                    'keterangan' => 'nullable|string',
                ],
                [
                    'kode_lokasi.required' => 'Kode lokasi harus diisi.',
                    'kode_lokasi.unique' => 'Kode lokasi sudah digunakan.',
                    'nama_lokasi.required' => 'Nama lokasi harus diisi.',
                    'pic.string' => 'PIC harus berupa string.',
                    'keterangan.string' => 'Keterangan harus berupa string.',
                ]
            );
            // Membuat data lokasi baru
            $lokasi = Lokasi::create($validated);
            return response()->json([
                'message' => 'Data lokasi berhasil ditambahkan.',
                'data' => $lokasi
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function show(Lokasi $lokasi)
    {
        return $lokasi;
    }

    public function update(Request $request, Lokasi $lokasi)
    {
        try {

            $validated = $request->validate(
                [
                    'kode_lokasi' => 'sometimes|string|unique:lokasis,kode_lokasi,' . $lokasi->id,
                    'nama_lokasi' => 'sometimes|string',
                    'pic' => 'sometimes|string',
                    'keterangan' => 'sometimes|string',
                ],
                [
                    'kode_lokasi.unique' => 'Kode lokasi sudah digunakan.',
                    'nama_lokasi.required' => 'Nama lokasi harus diisi.',
                    'pic.string' => 'PIC harus berupa string.',
                    'keterangan.string' => 'Keterangan harus berupa string.',
                ]
            );

            $lokasi->update($validated);
            return response()->json([
                'message' => 'Data lokasi berhasil diperbarui.',
                'data' => $lokasi
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function destroy(Lokasi $lokasi)
    {
        $lokasi->delete();
        return response()->json(['message' => 'Data lokasi berhasil dihapus.']);
    }
}
