<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusPengembalianToTglTransaksi extends Migration
{
    public function up()
    {
        Schema::table('tgl_transaksi', function (Blueprint $table) {
            $table->enum('status_pengembalian', ['pending', 'completed', 'rejected'])->nullable()->after('status_approval');
        });
    }

    public function down()
    {
        Schema::table('tgl_transaksi', function (Blueprint $table) {
            $table->dropColumn('status_pengembalian');
        });
    }
}
