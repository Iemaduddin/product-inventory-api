<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasUuids;
    protected $fillable = ['kode_lokasi', 'nama_lokasi',  'pic', 'keterangan'];

    public function produk()
    {
        return $this->belongsToMany(Produk::class, 'produk_lokasis')
            ->withPivot('stok', 'stok_minimal', 'updated_by')
            ->withTimestamps();
    }
}
