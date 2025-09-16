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
        Schema::create('producto_colors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->string('color_hex', 7); // Para almacenar el color en formato hexadecimal (#FFFFFF)
            $table->string('color_name')->nullable(); // Nombre opcional del color
            $table->timestamps();

            $table->unique(['producto_id', 'color_hex']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_colors');
    }
};
