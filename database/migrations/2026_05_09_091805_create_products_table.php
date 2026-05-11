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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
        $table->string('nama_produk');
        $table->string('brand')->nullable();
        $table->text('deskripsi')->nullable();
        $table->integer('harga');
        $table->integer('stok')->default(1);
        $table->string('ukuran')->nullable();
        $table->string('warna')->nullable();
        $table->enum('gender', ['pria', 'wanita', 'unisex']);
        $table->string('gambar')->nullable();
        $table->boolean('is_discount')->default(false);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
