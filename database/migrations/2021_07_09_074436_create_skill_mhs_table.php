<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillMhsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skill_mhs', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('skill_id');
            $table->unsignedBigInteger('mhs_id');
            $table->timestamps();
        });

        Schema::table('skill_mhs', function ($table) {
            $table->foreign('skill_id')->references('id')->on('skill')->onDelete('cascade');
            $table->foreign('mhs_id')->references('id')->on('mahasiswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skill_mhs');
    }
}
