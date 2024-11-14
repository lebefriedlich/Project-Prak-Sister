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
            $table->text('komentar')->nullable();
            $table->integer('rating')->unsigned()->check(function ($column) {
                $column->between(1, 5);
            });
            $table->foreignId('id_user')->constrained('users')->references('id_user')->onDelete('cascade');
            $table->foreignId('id_event')->constrained('events')->references('id_event')->onDelete('cascade');
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
