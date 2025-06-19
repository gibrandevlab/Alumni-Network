<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('pendaftaran_event', function (Blueprint $table) {
            $table->string('metode_pembayaran')->nullable();
            $table->string('kode_pembayaran')->nullable();
        });
    }

    public function down()
    {
        Schema::table('pendaftaran_event', function (Blueprint $table) {
            $table->dropColumn(['metode_pembayaran', 'kode_pembayaran']);
        });
    }
};
