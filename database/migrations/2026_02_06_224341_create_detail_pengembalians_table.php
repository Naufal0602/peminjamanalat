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
       Schema::create('detail_pengembalian', function (Blueprint $table) {
            $table->id('id_detail_pengembalian');

            $table->foreignId('id_pengembalian')
                ->constrained('pengembalian', 'id_pengembalian')
                ->cascadeOnDelete();

            $table->foreignId('id_alat')
                ->constrained('alat', 'id_alat')
                ->cascadeOnDelete();

            $table->integer('jumlah');

            $table->enum('kondisi', [
                'baik',
                'rusak_ringan',
                'rusak_berat'
            ]);

            $table->integer('denda')->default(0);

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pengembalians');
    }
};
