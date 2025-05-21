// app/Models/User.php
protected $fillable = [
    'name', 'email', 'password', 'role', 'status'
];

1. MIGRATION

# migration user table

<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_users_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // Nama lengkap user
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('alumni'); // alumni/admin
            $table->string('status')->default('pending'); // pending/approved/rejected
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};