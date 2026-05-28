<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('user_id');
            $table->string('nama_dosen');
            $table->string('telepon_dosen')->nullable();
            $table->integer('NIP')->nullable();
            $table->string('foto_dosen')->nullable()->default('avatar.png');
            $table->enum('jenis_kelamin',['Laki-laki','Perempuan'])->nullable();
            $table->unsignedBigInteger('depart_id')->nullable();
            $table->timestamps();
        });

        Schema::table('dosen', function ($table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('dosen');
    }
}
