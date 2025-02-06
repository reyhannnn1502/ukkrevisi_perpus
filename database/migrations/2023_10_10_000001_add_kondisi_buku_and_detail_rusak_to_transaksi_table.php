 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKondisiBukuAndDetailRusakToTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tgl_transaksi', function (Blueprint $table) {
            $table->string('kondisi_buku')->nullable()->after('status_pengembalian');
            $table->string('detail_rusak')->nullable()->after('kondisi_buku');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tgl_transaksi', function (Blueprint $table) {
            $table->dropColumn('kondisi_buku');
            $table->dropColumn('detail_rusak');
        });
    }
}
