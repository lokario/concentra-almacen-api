<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPedidosTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tbl_pedido', function (Blueprint $table) {
            $table->id();
            $table->foreignId('factura_id')->constrained('tbl_factura');
            $table->foreignId('colocacion_id')->constrained('tbl_colocacion');
            $table->integer('cantidad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('tbl_pedido');
    }
}
