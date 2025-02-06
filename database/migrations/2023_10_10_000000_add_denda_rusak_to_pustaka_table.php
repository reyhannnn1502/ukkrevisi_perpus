<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDendaRusakToPustakaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_pustaka', function (Blueprint $table) {
            $table->integer('denda_rusak')->default(0)->after('denda_hilang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_pustaka', function (Blueprint $table) {
            $table->dropColumn('denda_rusak');
        });
    }
}
