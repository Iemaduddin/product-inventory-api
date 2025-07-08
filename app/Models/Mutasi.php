<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    use HasUuids;

    protected $fillable = ['produk_lokasi_id', 'user_id', 'tanggal', 'jenis_mutasi', 'jumlah', 'keterangan', 'no_dokumen', 'sumber_tujuan'];

    public function produkLokasi()
    {
        return $this->belongsTo(ProdukLokasi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
