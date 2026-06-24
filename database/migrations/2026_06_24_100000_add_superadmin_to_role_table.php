<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddSuperadminToRoleTable extends Migration
{
    public function up(): void
    {
        // Insert role Superadmin dengan id = 6
        DB::table('role')->insertOrIgnore([
            'id'         => 6,
            'role'       => 'Superadmin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('role')->where('id', 6)->delete();
    }
}
