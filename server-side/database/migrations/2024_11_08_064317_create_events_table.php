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
        Schema::create('events', function (Blueprint $table) {
            $table->id('id_event');
            $table->foreignId('id_lokasi')->constrained('lokasi_event')->references('id_lokasi')->onDelete('cascade');
            $table->string('nama_event');
            $table->date('tanggal_event');
            $table->text('deskripsi');
            $table->enum('status', ['Dibuka', 'Ditutup']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
