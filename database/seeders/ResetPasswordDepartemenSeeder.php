<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetPasswordDepartemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'admin2@simagang.id')->first();
        
        if (!$user) {
            $this->command->error('User dengan email admin2@simagang.id tidak ditemukan!');
            return;
        }
        
        // Reset password menjadi "password123"
        $user->password = Hash::make('password123');
        $user->save();
        
        $this->command->info('Password berhasil direset!');
        $this->command->info('Email: admin2@simagang.id');
        $this->command->info('Password: password123');
    }
}
