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
        Schema::create('status_pengawasans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wajib_pajak_id')->constrained('wajib_pajaks')->onDelete('cascade');
            $table->text('permasalahan')->nullable();
            $table->text('tindak_lanjut')->nullable();
            $table->text('hasil')->nullable();
            $table->enum('status', ['SELESAI', 'BELUM'])->default('BELUM');
            $table->string('file_dokumen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_pengawasans');
    }
};
