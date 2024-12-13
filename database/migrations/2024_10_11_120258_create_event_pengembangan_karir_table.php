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
            $table->string('judul_event', 255)->nullable(false); // Judul event
            $table->text('deskripsi_event')->nullable(false); // Deskripsi event
            $table->timestamp('tanggal_mulai')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable(false);
            $table->timestamp('tanggal_akhir')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable(false);
            $table->string('dilaksanakan_oleh', 100)->nullable(false); // Pelaksana event
            $table->enum('tipe_event', ['loker', 'event'])->default('event'); // Tipe event
            $table->string('foto')->nullable()->comment('Path atau URL foto event'); // Tambahkan kolom foto
            $table->string('link')->nullable()->comment('Link event'); // Tambahkan kolom link
            $table->timestamps();
            $table->softDeletes(); // Jika diperlukan fitur soft deletes
            $table->index('judul_event'); // Indeks untuk kolom judul_event
            $table->index('tanggal_mulai'); // Indeks untuk kolom tanggal_mulai
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

