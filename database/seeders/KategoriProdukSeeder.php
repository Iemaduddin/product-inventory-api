<?php

namespace Database\Seeders;

use App\Models\KategoriProduk;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriProduk::insert([
            [
                'id' => uuid_create(),
                'nama_kategori' => 'Elektronik',
                'kode_kategori' => 'ELEC',
                'deskripsi' => 'Peralatan elektronik',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => uuid_create(),
                'nama_kategori' => 'Peralatan Kantor',
                'kode_kategori' => 'OFFC',
                'deskripsi' => 'Alat-alat tulis & kerja',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => uuid_create(),
                'nama_kategori' => 'Kesehatan',
                'kode_kategori' => 'HEAL',
                'deskripsi' => 'Produk kesehatan (P3K)',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
