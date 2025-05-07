<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponKuesionerTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('respon_kuesioner', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_kuesioner_id')
                ->constrained('event_kuesioner')
                ->onDelete('cascade')
                ->index('idx_respon_event_kuesioner'); // Index dengan nama khusus
            $table->json('jawaban')->nullable(); // Jawaban dalam format JSON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respon_kuesioner');
    }
}
