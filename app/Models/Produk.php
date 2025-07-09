<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasUuids;
    protected $fillable = ['nama_produk', 'kode_produk', 'kategori_id', 'merk', 'satuan', 'spesifikasi', 'harga_satuan'];

    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_id');
    }
    public function produkLokasis()
    {
        return $this->hasMany(ProdukLokasi::class, 'produk_id');
    }
    public function lokasi()
    {
        return $this->belongsToMany(Lokasi::class, 'produk_lokasis')->withPivot('stok', 'stok_minimal', 'updated_by')->withTimestamps();
    }
}
