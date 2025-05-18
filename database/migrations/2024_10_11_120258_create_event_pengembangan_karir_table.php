<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_pengembangan_karir', function (Blueprint $table) {
            $table->id();
            $table->string('judul_event', 255);
            $table->text('deskripsi_event');
            $table->date('tanggal_mulai')->nullable()->comment('Tanggal event dimulai');
            $table->date('tanggal_akhir_pendaftaran')->nullable()->comment('Tanggal terakhir pendaftaran dibuka');
            $table->string('dilaksanakan_oleh', 100);
            $table->enum('tipe_event', ['loker', 'event'])->default('event');
            $table->string('foto')->nullable();
            $table->string('link')->nullable();
            $table->integer('harga_daftar')->default(0);
            $table->integer('maksimal_peserta')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('judul_event');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_pengembangan_karir');
    }
};

