<?php

use App\Models\Categoria;
use App\Models\ImagenProducto;
use App\Models\Marca;
use App\Models\MarcaProducto;
use App\Models\Modelo;
use App\Models\SubCategoria;
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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('order')->default("zzz");
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('code_sr')->nullable();
            $table->longText('desc')->nullable();
            $table->unsignedBigInteger('unidad_pack')->default(1);
            $table->boolean('destacado')->default(false);
            $table->foreignIdFor(Categoria::class)->nullable()
                ->constrained('categorias')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
