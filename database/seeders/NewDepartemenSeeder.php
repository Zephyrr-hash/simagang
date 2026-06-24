<?php

namespace Database\Seeders;

use App\Models\Departemen;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NewDepartemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create new departemen user
        $user = User::firstOrCreate(
            ['email' => 'departemen@simagang.test'],
            [
                'name' => 'Departemen Admin',
                'role_id' => 1, // Departemen
                'password' => Hash::make('password123'),
            ]
        );

        // Create departemen profile
        Departemen::firstOrCreate(
            ['user_id' => $user->id],
            [
                'nama_depart' => 'Departemen Informatika',
                'telepon_depart' => '081234567890',
                'alamat_depart' => 'Jl. Kampus No. 1',
            ]
        );

        $this->command->info('✅ Akun Departemen baru berhasil dibuat!');
        $this->command->info('📧 Email: departemen@simagang.test');
        $this->command->info('🔑 Password: password123');
    }
}
