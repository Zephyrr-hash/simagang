<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupervisorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supervisor', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('user_id');
            $table->string('nama_spv');
            $table->string('telepon_spv')->nullable();
            $table->integer('no_pegawai')->nullable();
            $table->string('foto_spv')->nullable()->default('avatar.png');
            $table->enum('jenis_kelamin',['Laki-laki','Perempuan'])->nullable();
            $table->unsignedBigInteger('mitra_id')->nullable();
            $table->timestamps();
        });

        Schema::table('supervisor', function ($table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('mitra_id')->references('id')->on('mitra')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supervisor');
    }
}
