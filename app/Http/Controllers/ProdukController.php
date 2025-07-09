<?php

namespace App\Http\Controllers;

use App\Models\Mutasi;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProdukController extends Controller
{
    public function index()
    {
        // Mengambil semua produk dengan relasi kategori
        return Produk::with('kategori')->get();
    }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate(
                [
                    'kategori_id' => 'required|exists:kategori_produks,id',
                    'nama_produk' => 'required',
                    'kode_produk' => 'required|unique:produks',
                    'satuan' => 'required',
                ],
                [
                    'kategori_id.required' => 'Kategori produk harus diisi.',
                    'nama_produk.required' => 'Nama produk harus diisi.',
                    'kode_produk.required' => 'Kode produk harus diisi.',
                    'kode_produk.unique' => 'Kode produk sudah digunakan.',
                    'satuan.required' => 'Satuan harus diisi.',
                ]
            );

            // Buat produk baru
            $produk = Produk::create($validated);
            return response()->json([
                'message' => 'Produk berhasil ditambahkan.',
                'data' => $produk->load('kategori')
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function show(Produk $produk)
    {
        // Menampilkan detail produk dengan relasi kategori
        return $produk->load('kategori');
    }

    public function update(Request $request, Produk $produk)
    {
        try {
            // Validasi input untuk update produk
            $validated = $request->validate(
                [
                    'kategori_id' => 'sometimes|exists:kategori_produks,id',
                    'nama_produk' => 'sometimes|string',
                    'kode_produk' => 'sometimes|string|unique:produks,kode_produk,' . $produk->id,
                    'satuan' => 'sometimes|string',
                ],
                [
                    'kategori_id.exists' => 'Kategori produk tidak ditemukan.',
                    'nama_produk.string' => 'Nama produk harus berupa string.',
                    'kode_produk.unique' => 'Kode produk sudah digunakan.',
                    'satuan.string' => 'Satuan harus berupa string.',
                ]
            );
            // Update produk dengan data yang sudah divalidasi
            $produk->update($validated);
            return response()->json([
                'message' => 'Produk berhasil diperbarui.',
                'data' => $produk->load('kategori')
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function destroy(Produk $produk)
    {
        // Menghapus produk berdasarkan ID
        $produk->delete();
        return response()->json(['message' => 'Produk berhasil dihapus.']);
    }

    public function mutasi($id)
    {
        // Mengambil mutasi produk berdasarkan ID produk
        return Mutasi::with(['user', 'produkLokasi.produk', 'produkLokasi.lokasi'])
            ->whereHas('produkLokasi', function ($q) use ($id) {
                $q->where('produk_id', $id);
            })
            ->orderByDesc('tanggal')
            ->get();
    }
}
