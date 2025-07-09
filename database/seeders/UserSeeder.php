<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = [
            ["nama" => "Admin"],
            ["nama" => "Staff"],
            ["nama" => "Viewer"]
        ];

        foreach ($data as $user) {
            $role = Role::where('nama_role', $user['nama'])->first();
            User::create([
                'nama' => $user['nama'] . " User",
                'email' => strtolower($user["nama"]) . '@example.com',
                'password' => Hash::make('password'),
                'role_id' => $role->id,
                'is_active' => true
            ]);
        }
    }
}
