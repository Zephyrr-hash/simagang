<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills = [
            'VueJS', 'JavaScript', 'PHP', 'Laravel', 'Bootstrap',
        ];

        foreach ($skills as $skil) {
            Skill::firstOrCreate(['skill' => $skil]);
        }
    }
}
