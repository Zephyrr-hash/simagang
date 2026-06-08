<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectMagangTable extends Migration
{
    public function up(): void
    {
        Schema::create('project_magang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_project', 255)->comment('Nama project yang dikerjakan');
            $table->text('deskripsi')->nullable()->comment('Deskripsi singkat project');
            $table->text('tujuan')->nullable()->comment('Tujuan / scope project');
            $table->string('teknologi', 255)->nullable()->comment('Tech stack / tools yang digunakan');
            $table->enum('status', ['aktif', 'selesai', 'pending'])->default('aktif');
            $table->date('tgl_mulai')->nullable();
            $table->date('tgl_selesai')->nullable();
            $table->unsignedBigInteger('magang_id')->comment('FK ke tabel magang (mhs + spv)');
            $table->foreign('magang_id')->references('id')->on('magang')->onDelete('cascade');
            $table->index('magang_id');
            $table->timestamps();
        });

        // Tambah project_id ke logbook (opsional, bisa null — logbook bisa masuk ke project tertentu)
        Schema::table('logbook', function (Blueprint $table) {
            if (!Schema::hasColumn('logbook', 'project_id')) {
                $table->unsignedBigInteger('project_id')->nullable()->after('catatan_spv')
                      ->comment('FK ke project_magang, nullable (logbook bisa tanpa project)');
                $table->foreign('project_id')->references('id')->on('project_magang')
                      ->onDelete('set null');
                $table->index('project_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('logbook', function (Blueprint $table) {
            try { $table->dropForeign(['project_id']); } catch (\Exception $e) {}
            try { $table->dropIndex('logbook_project_id_index'); } catch (\Exception $e) {}
            if (Schema::hasColumn('logbook', 'project_id')) {
                $table->dropColumn('project_id');
            }
        });

        Schema::dropIfExists('project_magang');
    }
}
