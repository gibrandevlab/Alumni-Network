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
            $table->timestamp('tanggal_mulai')->useCurrent();
            $table->timestamp('tanggal_akhir')->useCurrent();
            $table->string('dilaksanakan_oleh', 100);
            $table->enum('tipe_event', ['loker', 'event'])->default('event');
            $table->string('foto')->nullable();
            $table->string('link')->nullable();
            $table->timestamps();
            $table->softDeletes();
        
            $table->index('judul_event');
            $table->index('tanggal_mulai');
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

