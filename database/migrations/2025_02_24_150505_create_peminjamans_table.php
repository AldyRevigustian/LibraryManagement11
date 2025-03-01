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
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->constrained('anggotas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('buku_id')->constrained('bukus')->onDelete('cascade')->onUpdate('cascade');
            $table->dateTime('tanggal_peminjaman');
            $table->dateTime('batas_pengembalian');
            $table->dateTime('tanggal_pengembalian')->nullable();
            $table->float('denda')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
