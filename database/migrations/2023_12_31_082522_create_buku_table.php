<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('judul_buku')->unique();
            $table->string('kategori_buku');
            $table->string('deskripsi');
            $table->integer('jumlah');
            $table->string('file_buku');
            $table->string('cover_buku');
            $table->string('uploaded_by');
            $table->foreign('kategori_buku')
                ->references('kategori_buku')->on('kategori')
                ->onDelete('NO ACTION')
                ->onUpdate('CASCADE');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
