<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kategori = [
            'Administrasi', 'Advertising & Public Relations', 'Agrikultur',
            'Akuntansi dan Keuangan', 'Arts & Entertainment & Publishing', 'Asuransi',
            'Customer Service', 'Desain', 'Event', 'Hospitality & Travel',
            'Hukum & Keamanan', 'Human Resources', 'Informasi & Teknologi',
            'Internet & New Media', 'Kecantikan', 'Kesehatan dan Kedokteran',
            'Konstruksi dan Bangunan', 'Management Consulting', 'Non-Profit & Volunteer',
            'Otomotif', 'Pabrik dan Manufaktur', 'Pekerjaan Umum',
            'Pelayanan Profesional', 'Pendidikan Dan Pelatihan', 'Penjualan / Pemasaran',
            'Perbankan', 'Programmer', 'Property & Real Estate',
            'Research & Development', 'Restaurant & Hotel', 'Retail',
            'Teknik', 'Telekomunikasi', 'Transportasi & Logistik',
        ];

        foreach ($kategori as $kat) {
            Kategori::firstOrCreate(['kategori' => $kat]);
        }
    }
}
