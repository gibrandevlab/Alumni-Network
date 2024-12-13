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
            $table->string('judul_event', 255); // Panjang maksimum judul_event
            $table->text('deskripsi_event');
            $table->string('foto')->nullable(); // Tambahkan nullable jika foto tidak harus diisi
            $table->timestamp('tanggal_mulai')->useCurrent(); // Hapus useCurrent jika ingin mengisi manual
            $table->timestamp('tanggal_akhir')->useCurrent(); // Hapus useCurrent jika ingin mengisi manual
            $table->integer('tahun_lulusan')->unsigned(); // Tambahkan unsigned jika tahun lulusan hanya bernilai positif
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

