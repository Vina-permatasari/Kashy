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
    Schema::create('shifts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('kasir_id')->constrained('users')->cascadeOnDelete();
        $table->integer('saldo_awal');
        $table->integer('saldo_akhir')->nullable();
        $table->integer('total_penjualan')->default(0);
        $table->enum('status', ['open', 'closed'])->default('open');
        $table->datetime('waktu_buka');
        $table->datetime('waktu_tutup')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
