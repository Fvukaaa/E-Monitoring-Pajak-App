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
        Schema::create('kepatuhan_bulanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wajib_pajak_id')->constrained('wajib_pajaks')->onDelete('cascade');
            $table->string('bulan');
            $table->enum('status_kepatuhan', ['PATUH', 'TIDAK PATUH'])->default('TIDAK PATUH');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kepatuhan_bulanans');
    }
};
