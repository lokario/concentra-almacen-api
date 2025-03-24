<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPY1STable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_p_y1', function (Blueprint $table) {
            $table->id();
            $table->string('usuario')->unique();
            $table->string('correo')->unique();
            $table->string('password');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('cedula');
            $table->string('telefono');
            $table->string('tipo_sangre');
            $table->string('sexo');
            $table->string('rol')->default('user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_p_y1_s');
    }
}
