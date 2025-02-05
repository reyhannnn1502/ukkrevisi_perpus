<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pustaka extends Model
{
    protected $table = 'tbl_pustaka';
    protected $primaryKey = 'id_pustaka';
    public $timestamps = true;
    
    protected $fillable = [
        'id_ddc',
        'id_format',
        'id_penerbit',
        'id_pengarang',
        'isbn',
        'judul_pustaka',
        'tahun_terbit',
        'keyword',
        'keterangan_fisik',
        'keterangan_tambahan',
        'abstraksi',
        'gambar',
        'harga_buku',
        'kondisi_buku',
        'fp',
        'jml_pinjam',
        'denda_terlambat',
        'denda_hilang'
    ];

    protected $attributes = [
        'fp' => '1', // Set default value to '1' (Tersedia)
        'jml_pinjam' => 0
    ];

    public function ddc()
    {
        return $this->belongsTo(DDC::class, 'id_ddc', 'id_ddc');
    }

    public function format()
    {
        return $this->belongsTo(Format::class, 'id_format', 'id_format');
    }

    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class, 'id_penerbit', 'id_penerbit');
    }

    public function pengarang()
    {
        return $this->belongsTo(Pengarang::class, 'id_pengarang', 'id_pengarang');
    }

    public function transactions()
    {
        return $this->hasMany(Transaksi::class, 'id_pustaka', 'id_pustaka');
    }

    public function activeLoans()
    {
        return $this->transactions()
            ->where('status_approval', 'approved')
            ->where('status_pengembalian', '0');
    }
}