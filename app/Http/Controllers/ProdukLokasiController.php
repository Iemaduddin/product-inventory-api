<?php

namespace App\Http\Controllers;

use App\Models\ProdukLokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ProdukLokasiController extends Controller
{
    public function index()
    {
        // Mengambil semua data ProdukLokasi dengan relasi produk dan lokasi
        return ProdukLokasi::with(['produk', 'lokasi'])->get();
    }
    public function store(Request $request)
    {
        try {
            // Validasi input
            $data = $request->validate(
                [
                    'produk_id' => 'required|exists:produks,id',
                    'lokasi_id' => 'required|exists:lokasis,id',
                    'stok' => 'required|integer|min:0',
                ],
                [
                    'produk_id.required' => 'Produk harus dipilih.',
                    'lokasi_id.required' => 'Lokasi harus dipilih.',
                    'stok.required' => 'Stok harus diisi.',
                    'stok.min' => 'Stok tidak boleh kurang dari 0.',
                ]
            );
            // Cek apakah produk sudah terdaftar di lokasi ini
            $existing = ProdukLokasi::where('produk_id', $data['produk_id'])
                ->where('lokasi_id', $data['lokasi_id'])
                ->first();
            // Jika sudah ada, kembalikan error
            if ($existing) {
                return response()->json(['message' => 'Produk sudah terdaftar di lokasi ini.'], 409);
            }
            // Jika belum ada, buat data baru
            $data['updated_by'] = Auth::id();

            // Inisialisasi stok awal
            $produkLokasi = ProdukLokasi::create($data);

            return response()->json([
                'message' => 'Stok awal berhasil diinisialisasi.',
                'data' => $produkLokasi->load(['produk', 'lokasi'])
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors(),
            ], 422);
        }
    }
}
