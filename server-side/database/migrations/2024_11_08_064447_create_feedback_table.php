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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id('id_feedback');
            $table->foreignId('id_pendaftaran')->constrained('pendaftaran')->references('id_pendaftaran')->onDelete('cascade');
            $table->text('komentar')->nullable();
            $table->integer('rating')->unsigned()->check(function ($column) {
                $column->between(1, 5);
            });
            $table->dateTime('tanggal_feedback');
            $table->enum('jenis_feedback', ['Kritik', 'Saran']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
