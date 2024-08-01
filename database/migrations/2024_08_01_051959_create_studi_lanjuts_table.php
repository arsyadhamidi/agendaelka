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
        Schema::create('studi_lanjuts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id');
            $table->foreignId('prodi_id');
            $table->foreignId('tahun_id');
            $table->string('nama');
            $table->string('pendidikan');
            $table->string('universitas');
            $table->string('berkas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('studi_lanjuts');
    }
};
