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
        Schema::create('pengabdians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_id');
            $table->date('tanggal');
            $table->text('judul');
            $table->text('lokasi');
            $table->string('file_pengabdian')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengabdians');
    }
};
