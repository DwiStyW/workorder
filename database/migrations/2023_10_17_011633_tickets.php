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
        Schema::create('tickets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('no_tiket');
            $table->timestamp('tanggal')->nullable();
            $table->string('pelapor');
            $table->string('divisi');
            $table->integer('mesin');
            $table->integer('ruang');
            $table->text('keterangan');
            $table->string('photo');
            $table->string('status');
            $table->string('update_by');
            $table->string('kepala');
            $table->string('anggota');
            $table->string('prioritas');
            $table->string('kategori_wo');
            $table->string('durasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};