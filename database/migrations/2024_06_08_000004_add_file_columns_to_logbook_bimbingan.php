<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileColumnsToLogbookBimbingan extends Migration
{
    public function up(): void
    {
        // Tambah kolom file di logbook (mahasiswa upload, SPV juga bisa upload)
        Schema::table('logbook', function (Blueprint $table) {
            if (!Schema::hasColumn('logbook', 'file')) {
                $table->string('file')->nullable()->after('catatan_spv')
                      ->comment('File attachment dari mahasiswa');
            }
            if (!Schema::hasColumn('logbook', 'file_spv')) {
                $table->string('file_spv')->nullable()->after('file')
                      ->comment('File attachment dari SPV (catatan/review)');
            }
        });

        // Tambah kolom feedback_file di bimbingan (dosen upload saat balas)
        Schema::table('bimbingan', function (Blueprint $table) {
            if (!Schema::hasColumn('bimbingan', 'feedback_file')) {
                $table->string('feedback_file')->nullable()->after('feedback')
                      ->comment('File attachment feedback dari dosen pembimbing');
            }
        });
    }

    public function down(): void
    {
        Schema::table('logbook', function (Blueprint $table) {
            if (Schema::hasColumn('logbook', 'file_spv')) $table->dropColumn('file_spv');
            if (Schema::hasColumn('logbook', 'file'))     $table->dropColumn('file');
        });

        Schema::table('bimbingan', function (Blueprint $table) {
            if (Schema::hasColumn('bimbingan', 'feedback_file')) $table->dropColumn('feedback_file');
        });
    }
}
