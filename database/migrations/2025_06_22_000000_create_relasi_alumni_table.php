<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relasi_alumni', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('alumni_utama_id');
            $table->unsignedBigInteger('alumni_teman_id');
            $table->enum('tipe_hubungan', ['teman', 'kolega', 'mentor', 'lainnya']);
            $table->string('deskripsi', 255)->nullable();
            $table->timestamps();

            $table->foreign('alumni_utama_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('alumni_teman_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relasi_alumni');
    }
};
