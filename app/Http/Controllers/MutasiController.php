<?php

namespace App\Http\Controllers;

use App\Models\Mutasi;
use App\Models\ProdukLokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MutasiController extends Controller
{
    public function index()
    {
        // Mengambil semua data mutasi dengan relasi produkLokasi, produk, lokasi, dan user
        return Mutasi::with(['produkLokasi.produk', 'produkLokasi.lokasi', 'user'])->get();
    }

    public function store(Request $request)
    {
        // Validasi input dari request
        $validated = $request->validate([
            'produk_lokasi_id' => 'required|exists:produk_lokasis,id',
            'tanggal' => 'required|date',
            'jenis_mutasi' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer|min:1',
        ]);
        // Mulai transaksi database
        return DB::transaction(function () use ($validated, $request) {
            // Membuat mutasi baru dengan data yang sudah divalidasi
            $mutasi = Mutasi::create([
                ...$validated,
                'user_id' => $request->user()->id,
                'keterangan' => $request->keterangan,
                'no_dokumen' => $request->no_dokumen,
                'sumber_tujuan' => $request->sumber_tujuan
            ]);
            // Mencari produk lokasi berdasarkan ID yang diberikan
            $produkLokasi = ProdukLokasi::findOrFail($validated['produk_lokasi_id']);
            // Memeriksa jenis mutasi dan mengupdate stok produk lokasi
            if ($validated['jenis_mutasi'] === 'masuk') {
                // Jika jenis mutasi adalah 'masuk', tambahkan jumlah ke stok
                $produkLokasi->stok += $validated['jumlah'];
            } else {
                // Jika jenis mutasi adalah 'keluar', kurangi jumlah dari stok
                if ($produkLokasi->stok < $validated['jumlah']) {
                    abort(400, 'Stok tidak mencukupi');
                }
                $produkLokasi->stok -= $validated['jumlah'];
            }
            // Set updated_by ke ID user yang melakukan mutasi
            $produkLokasi->updated_by = $request->user()->id;
            // Simpan perubahan pada produk lokasi
            $produkLokasi->save();
            // Kembalikan mutasi yang baru dibuat dengan relasi yang dimuat
            return $mutasi->load(['produkLokasi.produk', 'produkLokasi.lokasi', 'user']);
        });
    }

    public function show(Mutasi $mutasi)
    {
        // Menampilkan detail mutasi berdasarkan ID
        return $mutasi->load(['produkLokasi.produk', 'produkLokasi.lokasi', 'user']);
    }

    public function destroy(Mutasi $mutasi)
    {
        // Menghapus mutasi berdasarkan ID
        $mutasi->delete();
        return response()->json(['message' => 'Mutasi berhasil dihapus.']);
    }

    public function userMutasi($id)
    {
        // Mengambil semua mutasi yang dibuat oleh user dengan ID tertentu
        return Mutasi::with(['produkLokasi.produk', 'produkLokasi.lokasi'])
            ->where('user_id', $id)
            ->get();
    }
}
