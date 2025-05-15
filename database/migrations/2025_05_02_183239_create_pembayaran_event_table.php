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
        Schema::create('pembayaran_event', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_event_id')
            ->constrained('pendaftaran_event') // Referensi tabel 'pendaftaran_event'
            ->onDelete('cascade') // Hapus data terkait jika data dihapus
            ->index('idx_pendaftaran_event_id'); // Berikan nama unik pada index
            $table->enum('status_pembayaran', ['menunggu', 'berhasil', 'gagal'])->default('menunggu');
            $table->string('midtrans_transaction_id')->nullable(); // ID transaksi dari Midtrans
            $table->decimal('jumlah', 10, 2); // Jumlah yang dibayar
            $table->timestamp('waktu_pembayaran')->nullable(); // Waktu pembayaran
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_event');
    }
};
