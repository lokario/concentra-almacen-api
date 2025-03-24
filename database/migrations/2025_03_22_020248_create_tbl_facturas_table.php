<?php

use App\Support\Constants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblFacturasTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tbl_factura', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('tbl_cliente');
            $table->dateTime('fecha');
            $table->string('estado')->default(Constants::FACTURA_FINALIZADA);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('tbl_factura');
    }
}
