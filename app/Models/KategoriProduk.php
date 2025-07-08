<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    use HasUuids;

    protected $fillable = ['nama_kategori', 'kode_kategori', 'deskripsi'];

    public function produk()
    {
        return $this->hasMany(Produk::class);
    }
}
