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
        Schema::create('pertanyaan_kuesioner', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_kuesioner_id');
            $table->enum('kategori', ['umum', 'bekerja', 'pendidikan', 'lainnya']);
            $table->enum('tipe', ['pilihan', 'likert', 'esai']);
            $table->integer('urutan');
            $table->text('pertanyaan');
            $table->json('skala')->nullable();
            $table->timestamps();

            $table->foreign('event_kuesioner_id')
                ->references('id')->on('event_kuesioner')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_kuesioner');
    }
};
