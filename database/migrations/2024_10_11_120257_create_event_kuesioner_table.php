<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_kuesioner', function (Blueprint $table) {
            $table->id();
            $table->string('judul_event', 255);
            $table->text('deskripsi_event');
            $table->string('foto')->nullable(); // Foto optional
            $table->year('tahun_mulai'); // Mengganti tanggal_mulai menjadi tahun_mulai
            $table->year('tahun_akhir'); // Mengganti tanggal_akhir menjadi tahun_akhir
            $table->integer('tahun_lulusan')->unsigned()->nullable(); // Nullable jika tidak ada
            $table->timestamps();
        });    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_kuesioner');
    }
};

