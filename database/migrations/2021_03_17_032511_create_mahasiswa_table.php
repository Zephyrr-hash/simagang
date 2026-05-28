<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('user_id');
            $table->string('nama_mhs');
            $table->string('NIM')->nullable();
            $table->string('telepon_mhs')->nullable();
            $table->string('pengalaman')->nullable();
            $table->unsignedBigInteger('jurusan_id')->nullable();
            $table->unsignedBigInteger('status_id')->default('1')->nullable();
            $table->enum('jenis_kelamin',['Laki-laki','Perempuan'])->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('foto_mhs')->nullable()->default('avatar.png');
            $table->unsignedBigInteger('depart_id')->nullable();
            $table->timestamps();
        });

        Schema::table('mahasiswa', function ($table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade');
            $table->foreign('jurusan_id')->references('id')->on('jurusan')->onDelete('cascade');
            $table->foreign('depart_id')->references('id')->on('departemen')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
}
