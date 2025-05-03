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
        Schema::create('pendaftaran_event', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('event_pengembangan_karir')->onDelete('cascade')
                  ->name('fk_pendaftaran_event_event_pengembangan_karir'); // Berikan nama unik pada foreign key constraint
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')
                  ->name('fk_pendaftaran_event_user'); // Berikan nama unik pada foreign key constraint
            $table->enum('status', ['menunggu', 'berhasil'])->default('menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_event');
    }
};

