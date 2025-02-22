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
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ISBN');
            $table->text('judul');
            $table->string('kontributor', 125);
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('penerbit_id')->constrained('penerbits')->onDelete('cascade')->onUpdate('cascade');
            $table->smallInteger('stok');
            $table->string('tahun_terbit', 30);
            $table->string('deskripsi_fisik', 125);
            $table->text('deskripsi');
            $table->text('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
