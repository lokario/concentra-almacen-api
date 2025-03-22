<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTblPY1Fields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('tbl_p_y1', 'nombre')) {
            Schema::table('tbl_p_y1', function (Blueprint $table) {
                $table->dropColumn('nombre');
            });
        }

        Schema::table('tbl_p_y1', function (Blueprint $table) {
            $table->string('username')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('sex');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
