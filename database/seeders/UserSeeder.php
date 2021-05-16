<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            
            'username' => 'Admin',
            'nama' => 'Admin',
            'tipe_user' => 'admin',
            'nomor_hp' => '-',
            'password' => bcrypt('admin12345'),
            // 'nomor_hp' => '082385786666'
        ]);

        $admin->assignRole('admin');

        // $user = User::create([
        //     'name' => 'Pegawai1',
        //     'email' => 'pegawai@gmail.id',
        //     'password' => bcrypt('12345'),
        //     'nomor_hp' => '082385711666'
        // ]);

        // $user->assignRole('pegawai');
    }
}
