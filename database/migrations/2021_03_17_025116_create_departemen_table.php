<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartemenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departemen', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->string('nama_depart');
            $table->string('alamat_depart')->nullable();
            $table->string('telepon_depart')->nullable();
            $table->integer('NIDN')->nullable();
            $table->string('foto_depart')->nullable()->default('avatar.png');
            $table->timestamps();
        });

        Schema::table('departemen', function ($table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departemen');
    }
}
