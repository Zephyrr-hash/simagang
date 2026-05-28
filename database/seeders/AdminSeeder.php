<?php

namespace Database\Seeders;

use App\Models\Departemen;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@simagang.id'],
            [
                'name' => 'Admin',
                'role_id' => 1,
                'password' => bcrypt('adminsimagang'),
            ]
        );

        Departemen::firstOrCreate(
            ['user_id' => $admin->id],
            ['nama_depart' => $admin->name]
        );
    }
}
