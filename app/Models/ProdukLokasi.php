<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ProdukLokasi extends Model
{
    use HasUuids;
    protected $fillable = ['produk_id', 'lokasi_id', 'stok', 'stok_minimal', 'updated_by'];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    // Relasi ke Mutasi (1 produk_lokasi bisa punya banyak mutasi)
    public function mutasis()
    {
        return $this->hasMany(Mutasi::class, 'produk_lokasi_id');
    }
}
