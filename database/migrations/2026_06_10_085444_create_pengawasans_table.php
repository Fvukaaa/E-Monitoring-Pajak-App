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
        Schema::create('pengawasans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wajib_pajak_id')->constrained('wajib_pajaks')->onDelete('cascade');
            $table->date('tanggal')->nullable();
            $table->string('file_surat_tugas')->nullable();
            $table->string('file_bap')->nullable();
            $table->string('file_laporan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengawasans');
    }
};
