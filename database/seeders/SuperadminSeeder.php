<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class SuperadminSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan role Superadmin ada
        \Illuminate\Support\Facades\DB::table('role')->insertOrIgnore([
            'id'         => 6,
            'role'       => 'Superadmin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Buat akun Superadmin
        $user = User::updateOrCreate(
            ['email' => 'superadmin@simagang.test'],
            [
                'name'               => 'Super Administrator',
                'password'           => Hash::make('superadmin123'),
                'role_id'            => 6,
                'email_verified_at'  => now(),
            ]
        );

        $this->command->info('✅ Superadmin berhasil dibuat!');
        $this->command->info('   Email    : superadmin@simagang.test');
        $this->command->info('   Password : superadmin123');
    }
}
