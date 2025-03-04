@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Riwayat Peminjaman</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($transactions->isEmpty())
                        <div class="alert alert-info">
                            Anda belum memiliki riwayat peminjaman buku.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Judul Buku</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Status</th>
                                        <th>Denda</th>
                                        <th>Kondisi</th> <!-- Added this line -->
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $index => $transaction)
                                        <tr>
                                            <td>{{ $index + $transactions->firstItem() }}</td>
                                            <td>
                                                <strong>{{ $transaction->pustaka->judul_pustaka }}</strong>
                                                <br>
                                                <small class="text-muted">
                                                    Pengarang: {{ $transaction->pustaka->pengarang->nama_pengarang }}
                                                </small>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($transaction->tgl_pinjam)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($transaction->tgl_kembali)->format('d/m/Y') }}</td>
                                            <td>
                                                @if($transaction->status_approval == 'pending')
                                                    <span class="badge bg-warning">Menunggu Persetujuan</span>
                                                @elseif($transaction->status_approval == 'approved')
                                                    @if($transaction->status_pengembalian == 'pending')
                                                        <span class="badge bg-info">Menunggu Persetujuan Pengembalian</span>
                                                    @elseif($transaction->fp == '1')
                                                        <span class="badge bg-success">Selesai</span>
                                                    @else
                                                        <span class="badge bg-primary">Sedang Dipinjam</span>
                                                    @endif
                                                @elseif($transaction->status_approval == 'rejected')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $denda = 0;
                                                    if(!$transaction->tgl_pengembalian && $transaction->status_approval == 'approved') {
                                                        $tglKembali = \Carbon\Carbon::parse($transaction->tgl_kembali);
                                                        if($tglKembali->lt(\Carbon\Carbon::now())) {
                                                            $denda = $tglKembali->diffInDays(\Carbon\Carbon::now()) * ($transaction->pustaka->denda_terlambat ?? 0);
                                                        }
                                                    }
                                                    if ($transaction->kondisi_buku == 'rusak') {
                                                        $denda += $transaction->detail_rusak == 'ringan' ? $transaction->pustaka->denda_rusak * 0.5 : $transaction->pustaka->denda_rusak;
                                                    } elseif ($transaction->kondisi_buku == 'hilang') {
                                                        $denda += $transaction->pustaka->denda_hilang;
                                                    }
                                                @endphp
                                                Rp {{ number_format($denda, 0, ',', '.') }}
                                            </td>
                                            <td>{{ $transaction->kondisi_buku ?: '-' }}</td> <!-- Added this line -->
                                            <td>
                                                @if($transaction->status_approval == 'rejected')
                                                    <span class="text-danger">{{ $transaction->reject_reason }}</span>
                                                @else
                                                    {{ $transaction->keterangan ?: '-' }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            {{ $transactions->links() }}
                        </div>
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('home') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th {
        background-color: #f8f9fa;
    }
    .badge {
        font-size: 0.85em;
    }
</style>
@endpush
