<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_profil_alumni_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profil_alumni', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('nama_lengkap')->nullable();
            $table->string('nim')->nullable();
            $table->string('jurusan')->nullable();
            $table->integer('tahun_masuk')->nullable();
            $table->integer('tahun_lulus')->nullable();
            $table->float('ipk')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('no_telepon', 20)->nullable();
            $table->string('alamat_rumah', 255)->nullable();
            $table->string('instagram', 100)->nullable();
            $table->string('email_alternatif')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('profil_alumni');
    }
};