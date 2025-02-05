<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'tgl_transaksi';
    protected $primaryKey = 'id_transaksi';
    
    protected $fillable = [
        'id_pustaka',
        'id_anggota',
        'tgl_pinjam',
        'tgl_kembali',
        'tgl_pengembalian',
        'fp',
        'keterangan',
        'status_approval',
        'status_pengembalian',
        'reject_reason',
        'created_at',
        'updated_at'
    ];

    protected $dates = [
        'tgl_pinjam',
        'tgl_kembali',
        'tgl_pengembalian',
        'created_at',
        'updated_at'
    ];

    // Define relationships
    public function pustaka()
    {
        return $this->belongsTo(Pustaka::class, 'id_pustaka', 'id_pustaka')
            ->withDefault(['judul_pustaka' => 'Buku tidak ditemukan']);
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota')
            ->withDefault(['nama_anggota' => 'Anggota tidak ditemukan']);
    }

    // Add scope for active loans
    public function scopeActive($query)
    {
        return $query->where('status_approval', 'approved')
                     ->where('status_pengembalian', '0');
    }

    // Helper method to check if transaction is active
    public function isActive()
    {
        return $this->status_approval === 'approved' && $this->fp === '0';
    }

    // Helper method to check if transaction is pending
    public function isPending()
    {
        return $this->status_approval === 'pending';
    }
}