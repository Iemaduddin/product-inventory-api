<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriProduk;
use Illuminate\Validation\ValidationException;

class KategoriProdukController extends Controller
{
    public function index()
    {
        // Mengambil semua kategori produk
        return KategoriProduk::all();
    }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $data = $request->validate(
                [
                    'nama_kategori' => 'required|string',
                    'kode_kategori' => 'required|string|unique:kategori_produks,kode_kategori',
                    'deskripsi' => 'nullable|string',
                ],
                [
                    'kode_kategori.unique' => 'Kode kategori sudah digunakan.',
                    'nama_kategori.required' => 'Nama kategori harus diisi.',
                ]
            );
            // Membuat kategori produk baru
            $kategori = KategoriProduk::create($data);
            // Mengembalikan respons sukses
            return response()->json([
                'message' => 'Kategori berhasil ditambahkan.',
                'data' => $kategori
            ], 201);
        } catch (ValidationException $e) {
            // Menangani validasi yang gagal
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors(),
            ], 422);
        }
    }


    public function show(KategoriProduk $kategoriProduk)
    {
        // Menampilkan detail kategori produk berdasarkan ID
        return $kategoriProduk;
    }

    public function update(Request $request, KategoriProduk $kategoriProduk)
    {
        try {
            // Validasi input untuk update
            $data = $request->validate(
                [
                    'nama_kategori' => 'sometimes|string',
                    'kode_kategori' => 'sometimes|string|unique:kategori_produks,kode_kategori,' . $kategoriProduk->id,
                    'deskripsi' => 'nullable|string',
                ],
                [
                    'kode_kategori.unique' => 'Kode kategori sudah digunakan.',
                    'nama_kategori.required' => 'Nama kategori harus diisi.',
                ]
            );
            // Update kategori produk
            $kategoriProduk->update($data);
            // Mengembalikan respons sukses
            return response()->json([
                'message' => 'Kategori produk berhasil diperbarui.',
                'data' => $kategoriProduk
            ], 200);
        } catch (ValidationException $e) {
            // Menangani validasi yang gagal
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function destroy(KategoriProduk $kategoriProduk)
    {
        // Menghapus kategori produk berdasarkan ID
        $kategoriProduk->delete();
        return response()->json(['message' => 'Kategori produk berhasil dihapus.']);
    }
}
