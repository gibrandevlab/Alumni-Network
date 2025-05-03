<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponKuesionerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respon_kuesioner', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_kuesioner_id')->constrained('event_kuesioner')->onDelete('cascade')
                  ->name('fk_respon_event_kuesioner'); // Berikan nama unik untuk foreign key constraint
            $table->text('jawaban'); // Kolom jawaban
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('respon_kuesioner');
    }
}

