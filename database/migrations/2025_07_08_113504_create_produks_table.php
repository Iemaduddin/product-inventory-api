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
        Schema::create('produks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('kategori_id');
            $table->string('nama_produk');
            $table->string('kode_produk')->unique();
            $table->string('merk')->nullable();
            $table->string('satuan');
            $table->text('spesifikasi')->nullable();
            $table->decimal('harga_satuan', 15, 2)->nullable();
            $table->timestamps();

            $table->foreign('kategori_id')->references('id')->on('kategori_produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
