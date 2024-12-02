<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('precio', 10, 2);
            $table->longText('imagen')->nullable(); // Cambié 'string' por 'text'
            $table->string('descripcion');
            $table->tinyInteger('estatus')->default(1); // 1=activo, 2=inactivo, 3=pendiente
            $table->unsignedBigInteger('user_id'); // Agregar la columna user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Establecer la clave foránea
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
