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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained('warehouses')->onDelete('cascade')->cascadeOnUpdate(); // Relasi ke cabang
            $table->string('name')->index(); // Nama pemasok dengan indeks untuk pencarian cepat
            $table->string('contact')->nullable(); // Informasi kontak (telepon atau email)
            $table->string('address')->nullable(); // Alamat pemasok
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
