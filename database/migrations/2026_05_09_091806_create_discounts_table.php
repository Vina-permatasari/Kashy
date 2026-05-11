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
    Schema::create('discounts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
        $table->enum('tipe_diskon', ['persen', 'fixed']);
        $table->integer('nilai_diskon');
        $table->date('tanggal_mulai');
        $table->date('tanggal_selesai');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
