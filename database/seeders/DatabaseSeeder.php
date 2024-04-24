<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Role::create([
            'role_name' => 'superadmin',
        ]);
        User::create([
            'username' => 'admin',
            'password' => bcrypt('iqbal@0123'),
            'email' => 'iqbalazzahir@gmail.com',
            'nama_lengkap' => 'Moch. Iqbal Az-zahir',
            'alamat' => 'Jakarta',
            'is_admin' => 1
        ]);
        User::create([
            'username' => 'rio',
            'password' => bcrypt('123'),
            'email' => 'riokiong12@gmail.com',
            'nama_lengkap' => 'Rio Havid Pradana',
            'alamat' => 'Jakarta',
        ]);
        User::create([
            'username' => 'rey',
            'password' => bcrypt('123'),
            'email' => 'dinatasy04@gmail.com',
            'nama_lengkap' => 'Reyhan Dinata',
            'alamat' => 'Jakarta',
        ]);
    }
}











