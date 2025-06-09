<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pertanyaan_kuesioners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kuesioner_id')->constrained('kuesioners')->onDelete('cascade');
            $table->string('pertanyaan');
            $table->enum('tipe', ['likert', 'esai', 'pilihan']);
            $table->string('skala')->nullable(); // untuk likert/pilihan, null untuk esai
            $table->integer('urutan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_kuesioners');
    }
}; 