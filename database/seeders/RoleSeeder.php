<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'Departemen',
            'Mitra',
            'Dosen Pembimbing',
            'Supervisor',
            'Mahasiswa',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['role' => $role]);
        }
    }
}
