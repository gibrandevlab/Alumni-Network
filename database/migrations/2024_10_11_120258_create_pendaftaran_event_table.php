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
            $table->id()->primary()->autoIncrement()->notNullable();
            $table->foreignId('event_id')->constrained('event_pengembangan_karir')->notNullable();
            $table->foreignId('user_id')->constrained('users')->notNullable();
            $table->enum('status_pendaftaran', ['dalam_proses', 'diterima', 'ditolak'])->notNullable();
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

