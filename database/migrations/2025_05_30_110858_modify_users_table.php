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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id_user'); // Sesuaikan dengan kolom int id_user
            $table->string('username', 50)->unique();
            $table->string('nama_lengkap', 200);
            $table->string('password', 355);
            $table->text('cek_password')->nullable();
            $table->string('level', 2);
            $table->string('id_kampus', 15)->nullable();
            $table->string('unit', 200)->nullable();
            $table->string('email', 100)->unique();
            $table->string('kd_dosen', 5)->nullable();
            $table->string('jabatan', 200)->nullable();
            $table->text('foto')->nullable();
            $table->text('reset_token')->nullable();
            $table->string('no_wa', 13)->nullable();
            $table->string('mvtim', 15)->nullable(); // Perbaiki nama kolom sesuai DB
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
