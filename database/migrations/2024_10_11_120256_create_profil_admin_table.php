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
        Schema::create('profil_admin', function (Blueprint $table) {
            $table->id()->primary()->autoIncrement()->notNullable();
            $table->foreignId('user_id')->constrained('users')->notNullable();
            $table->string('nama')->nullable();
            $table->string('email')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('jabatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_admin');
    }
};

