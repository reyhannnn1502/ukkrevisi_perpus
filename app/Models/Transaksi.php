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
        'updated_at',
        'kondisi_buku',
        'detail_rusak'
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

    // Method to calculate the fine dynamically
    public function calculateFine()
    {
        $denda = 0;
        if(!$this->tgl_pengembalian && $this->status_approval == 'approved') {
            $tglKembali = \Carbon\Carbon::parse($this->tgl_kembali);
            if($tglKembali->lt(\Carbon\Carbon::now())) {
                $denda = $tglKembali->diffInDays(\Carbon\Carbon::now()) * ($this->pustaka->denda_terlambat ?? 0);
            }
        }
        if ($this->kondisi_buku == 'rusak') {
            $denda += $this->detail_rusak == 'ringan' ? $this->pustaka->denda_rusak * 0.5 : $this->pustaka->denda_rusak;
        } elseif ($this->kondisi_buku == 'hilang') {
            $denda += $this->pustaka->denda_hilang;
        }
        return $denda;
    }
}