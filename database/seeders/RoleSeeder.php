<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['id' => uuid_create(), 'nama_role' => 'admin', 'deskripsi' => 'Administrator', 'is_active' => true],
            ['id' => uuid_create(), 'nama_role' => 'staff', 'deskripsi' => 'Staf operasional', 'is_active' => true],
            ['id' => uuid_create(), 'nama_role' => 'viewer', 'deskripsi' => 'Hanya lihat data', 'is_active' => true],
        ]);
    }
}
