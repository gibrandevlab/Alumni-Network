<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')
                  ->index('idx_messages_user'); // Berikan nama unik pada indeks
            $table->text('message'); // Pesan teks, tidak boleh null
            $table->string('media_path')->nullable(); // Path file media, bisa null
            $table->string('media_type')->nullable(); // Tipe media (image/video), bisa null
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
