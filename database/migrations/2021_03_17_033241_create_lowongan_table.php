<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLowonganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lowongan', function (Blueprint $table) {
            $table->id('id');
            $table->string('nama_low');
            $table->string('deskripsi_low');
            $table->string('telepon_low');
            $table->integer('jumlah_mhs');
            $table->string('durasi');
            $table->unsignedBigInteger('mitra_id');
            $table->unsignedBigInteger('kategori_id');
            $table->string('lokasi');
            $table->string('foto_low')->nullable()->default('bg.png');
            $table->timestamps();
        });

        Schema::table('lowongan', function ($table) {
            $table->foreign('mitra_id')->references('id')->on('mitra')->onDelete('cascade');
            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lowongan');
    }
}
