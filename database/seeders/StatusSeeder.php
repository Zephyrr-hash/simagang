<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            'Belum Magang',
            'Sedang Magang',
            'Sudah Magang',
            'Sedang Mengajukan',
        ];

        foreach ($statuses as $status) {
            Status::firstOrCreate(['status' => $status]);
        }
    }
}
