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
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id('id_pendaftaran');
            $table->foreignId('id_user')->constrained('users')->references('id_user')->onDelete('cascade');
            $table->foreignId('id_event')->constrained('events')->references('id_event')->onDelete('cascade');
            $table->date('tanggal_daftar');
            $table->enum('status_kehadiran', ['Hadir', 'Tidak Hadir']);
            $table->string('alasan_keikutsertaan');
            $table->enum('kategori_peserta', ['Mahasiswa', 'Dosen', 'Umum']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
