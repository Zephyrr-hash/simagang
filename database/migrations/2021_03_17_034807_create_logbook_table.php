<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogbookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logbook', function (Blueprint $table) {
            $table->id('id');
            $table->date('tanggal');
            $table->string('kegiatan');
            $table->string('deskripsi_log');
            $table->string('saran')->nullable();
            $table->unsignedBigInteger('magang_id');
            $table->timestamps();
        });

        Schema::table('logbook', function ($table) {
            $table->foreign('magang_id')->references('id')->on('magang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logbook');
    }
}
