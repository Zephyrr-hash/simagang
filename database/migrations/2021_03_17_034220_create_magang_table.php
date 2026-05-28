<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMagangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('magang', function (Blueprint $table) {
            $table->id('id');
            $table->date('tgl_mulai')->nullable();
            $table->date('tgl_selesai')->nullable();
            $table->unsignedBigInteger('mhs_id')->nullable();
            $table->unsignedBigInteger('dosen_id')->nullable();
            $table->unsignedBigInteger('spv_id')->nullable();
            $table->unsignedBigInteger('lowongan_id')->nullable();
            $table->integer('approval')->default('0')->nullable();
            $table->string('keterangan')->nullable();
            $table->integer('nilai')->nullable();
            $table->timestamps();
        });

        Schema::table('magang', function ($table) {
            $table->foreign('mhs_id')->references('id')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('dosen_id')->references('id')->on('dosen')->onDelete('cascade');
            $table->foreign('spv_id')->references('id')->on('supervisor')->onDelete('cascade');
            $table->foreign('lowongan_id')->references('id')->on('lowongan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('magang');
    }
}
