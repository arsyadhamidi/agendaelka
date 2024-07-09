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
        Schema::create('seminars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prodi_id');
            $table->foreignId('tahun_id');
            $table->foreignId('dosen_id');
            $table->foreignId('mahasiswa_id');
            $table->foreignId('penelaah1_id');
            $table->foreignId('penelaah2_id');
            $table->text('judul');
            $table->date('tgl_seminar');
            $table->date('tgl_ujian');
            $table->string('file_seminar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminars');
    }
};
