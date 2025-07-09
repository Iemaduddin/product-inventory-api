<?php

namespace Database\Seeders;

use App\Models\Lokasi;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => uuid_create(),
                'kode_lokasi' => 'GDG-01',
                'nama_lokasi' => 'Gudang Utama',
                'pic' => 'Didin',
                'keterangan' => 'Gudang pusat utama perusahaan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => uuid_create(),
                'kode_lokasi' => 'GDG-02',
                'nama_lokasi' => 'Gudang Cabang A',
                'pic' => 'Dudin',
                'keterangan' => 'Gudang cabang wilayah A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => uuid_create(),
                'kode_lokasi' => 'GDG-03',
                'nama_lokasi' => 'Gudang Cabang B',
                'pic' => 'Iemaduddin',
                'keterangan' => 'Gudang cabang wilayah B',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => uuid_create(),
                'kode_lokasi' => 'GDG-04',
                'nama_lokasi' => 'Gudang Cabang C',
                'pic' => 'M. Didin',
                'keterangan' => 'Gudang cabang wilayah C',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => uuid_create(),
                'kode_lokasi' => 'GDG-05',
                'nama_lokasi' => 'Gudang Sementara',
                'pic' => 'M. Dudin',
                'keterangan' => 'Gudang untuk penyimpanan sementara',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];

        Lokasi::insert($data);
    }
}
