<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jurusans = [
            'D4 Teknologi Rekayasa Perangkat Lunak (TRPL)',
            'D4 Teknologi Rekayasa Internet (TRI)',
            'D4 Teknologi Rekayasa Instrumentasi dan Kontrol (TRIK)',
            'D4 Teknologi Rekayasa Elektro (TRE)',
        ];

        foreach ($jurusans as $jurusan) {
            Jurusan::firstOrCreate(['jurusan' => $jurusan]);
        }
    }
}
