<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Alter event_pengembangan_karir
        Schema::table('event_pengembangan_karir', function (Blueprint $table) {
            $table->enum('status', ['aktif','nonaktif'])->default('aktif')->index()->change();
            $table->enum('tipe_event', ['loker','event'])->default('event')->index()->change();
            $table->string('judul_event', 255)->nullable(false)->change();
            $table->text('deskripsi_event')->nullable()->change();
            $table->date('tanggal_mulai')->nullable()->change();
            $table->date('tanggal_akhir_pendaftaran')->nullable()->change();
            $table->string('dilaksanakan_oleh', 100)->nullable(false)->change();
            $table->string('foto')->nullable()->change();
            $table->string('link')->nullable()->change();
            $table->integer('harga_daftar')->nullable()->change();
            $table->integer('maksimal_peserta')->nullable()->change();
            $table->index('tipe_event');
            $table->index('status');
        });
        // Alter pendaftaran_event
        Schema::table('pendaftaran_event', function (Blueprint $table) {
            $table->foreignId('event_id')->index()->change();
            $table->foreignId('user_id')->index()->change();
            $table->enum('status', ['menunggu','berhasil'])->default('menunggu')->index()->change();
        });
        // Alter pembayaran_event
        Schema::table('pembayaran_event', function (Blueprint $table) {
            $table->foreignId('pendaftaran_event_id')->index()->change();
            $table->enum('status_pembayaran', ['pending','capture','settlement','deny','expire','cancel'])->default('pending')->index()->change();
            $table->string('midtrans_transaction_id')->nullable()->change();
            $table->decimal('jumlah', 10, 2)->nullable()->change();
            $table->timestamp('waktu_pembayaran')->nullable()->change();
            $table->index('status_pembayaran');
        });
    }
    public function down(): void
    {
        // Tidak perlu implementasi down untuk alter efisiensi
    }
};
