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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('id_peminjaman');

            // siapa yang pinjam (user peminjam)
            $table->foreignId('id_peminjam')
                ->constrained('users')
                ->cascadeOnDelete();

            // petugas yang menyetujui
            $table->foreignId('id_petugas')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali_rencana');

            $table->enum('status', [
                'menunggu',
                'disetujui',
                'ditolak',
                'selesai'
            ])->default('menunggu');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
