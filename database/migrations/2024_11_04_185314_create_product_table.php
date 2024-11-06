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
            $table->id(); // Kolom ID
            $table->string('nama'); // Nama produk
            $table->decimal('harga', 10, 2); // Harga produk
            $table->integer('stok'); // Stok produk
            $table->text('deskripsi')->nullable(); // Deskripsi produk (nullable)
            $table->string('kategori'); // Kategori produk
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products'); // Menghapus tabel jika migrasi di-rollback
    }
};
