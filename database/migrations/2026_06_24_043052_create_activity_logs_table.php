<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // User yang melakukan aktivitas
            $table->string('role')->nullable(); // Role user (mahasiswa, mitra, dosen, dll)
            $table->string('action'); // Tipe aksi (login, create, update, delete, approve, reject)
            $table->string('module'); // Module/fitur (lowongan, user, magang, bimbingan, dll)
            $table->string('description'); // Deskripsi aktivitas (bahasa Indonesia)
            $table->text('details')->nullable(); // Detail data dalam JSON
            $table->string('ip_address', 45)->nullable(); // IP address user
            $table->string('user_agent')->nullable(); // Browser/device info
            $table->timestamps();

            // Index untuk performa query
            $table->index('user_id');
            $table->index('action');
            $table->index('module');
            $table->index('created_at');
            
            // Foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
}
