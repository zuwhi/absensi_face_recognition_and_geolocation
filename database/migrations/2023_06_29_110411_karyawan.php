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
        Schema::create('karyawan', function (Blueprint $table) {
            $table->integer('nik', 5);
            $table->string('nama_lengkap', 100);
            $table->string('foto', 100)->nullable()->default('NULL');
            $table->unsignedBigInteger('jabatan_id');
            $table->string('telepon', 15);
            $table->text('password');
            $table->text('verif_1')->nullable()->default('NULL');
            $table->text('verif_2')->nullable()->default('NULL');
            $table->string('remember_token', 100)->nullable()->default('NULL');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('jabatan_id')->references('id')->on('jabatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
