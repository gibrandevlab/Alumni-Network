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
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrati`ons.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
