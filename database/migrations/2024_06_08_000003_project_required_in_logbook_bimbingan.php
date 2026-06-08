<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProjectRequiredInLogbookBimbingan extends Migration
{
    public function up(): void
    {
        // =====================================================================
        // 1. Logbook — project_id wajib (NOT NULL), lepas magang_id sebagai
        //    navigasi utama (tetap ada untuk backward compat tapi logbook
        //    sekarang masuk via project)
        // =====================================================================
        Schema::table('logbook', function (Blueprint $table) {
            // Drop FK project_id yang nullable dulu
            try { $table->dropForeign(['project_id']); } catch (\Exception $e) {}
            try { $table->dropIndex('logbook_project_id_index'); } catch (\Exception $e) {}
        });

        // Ubah project_id jadi NOT NULL
        DB::statement('ALTER TABLE logbook MODIFY project_id BIGINT UNSIGNED NOT NULL');

        Schema::table('logbook', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('project_magang')
                  ->onDelete('cascade'); // Hapus logbook jika project dihapus
            $table->index('project_id', 'logbook_project_id_index');
        });

        // =====================================================================
        // 2. Bimbingan — tambah project_id (NOT NULL), sebagai pengganti magang_id
        //    sebagai navigasi utama
        // =====================================================================
        if (!Schema::hasColumn('bimbingan', 'project_id')) {
            DB::statement('ALTER TABLE bimbingan ADD COLUMN project_id BIGINT UNSIGNED NOT NULL AFTER magang_id');
            Schema::table('bimbingan', function (Blueprint $table) {
                $table->foreign('project_id')->references('id')->on('project_magang')
                      ->onDelete('cascade');
                $table->index('project_id', 'bimbingan_project_id_index');
            });
        }
    }

    public function down(): void
    {
        // Kembalikan logbook project_id ke nullable
        Schema::table('logbook', function (Blueprint $table) {
            try { $table->dropForeign(['project_id']); } catch (\Exception $e) {}
            try { $table->dropIndex('logbook_project_id_index'); } catch (\Exception $e) {}
        });
        DB::statement('ALTER TABLE logbook MODIFY project_id BIGINT UNSIGNED NULL');
        Schema::table('logbook', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('project_magang')
                  ->onDelete('set null');
        });

        // Hapus project_id dari bimbingan
        Schema::table('bimbingan', function (Blueprint $table) {
            try { $table->dropForeign(['project_id']); } catch (\Exception $e) {}
            try { $table->dropIndex('bimbingan_project_id_index'); } catch (\Exception $e) {}
            if (Schema::hasColumn('bimbingan', 'project_id')) {
                $table->dropColumn('project_id');
            }
        });
    }
}
