@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Request Pengembalian Buku</div>

                <div class="card-body">
                    @if(session('debug'))
                        <div class="alert alert-info">
                            {{ session('debug') }}
                        </div>
                    @endif

                    @if($activeBorrowings->isEmpty())
                        <div class="alert alert-info">
                            Tidak ada buku yang sedang dipinjam.
                            @if(auth()->user()->anggota)
                                <br>
                                ID Anggota: {{ auth()->user()->anggota->id_anggota }}
                            @endif
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Kode Transaksi</th>
                                        <th>Judul Buku</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activeBorrowings as $transaksi)
                                    <tr>
                                        <td>TRX-{{ str_pad($transaksi->id_transaksi, 5, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $transaksi->pustaka->judul_pustaka }}</td>
                                        <td>{{ \Carbon\Carbon::parse($transaksi->tgl_pinjam)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($transaksi->tgl_kembali)->format('d/m/Y') }}</td>
                                        <td>
                                            <button type="button" 
                                                    class="btn btn-primary btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#returnModal{{ $transaksi->id_transaksi }}">
                                                Ajukan Pengembalian
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Return Request Modals -->
                        @foreach($activeBorrowings as $transaksi)
                        <div class="modal fade" id="returnModal{{ $transaksi->id_transaksi }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('user.request.pengembalian', $transaksi->id_transaksi) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Request Pengembalian Buku</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Kode Transaksi</label>
                                                <input type="text" class="form-control" value="TRX-{{ str_pad($transaksi->id_transaksi, 5, '0', STR_PAD_LEFT) }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Buku</label>
                                                <input type="text" class="form-control" value="{{ $transaksi->pustaka->judul_pustaka }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Keterangan</label>
                                                <textarea name="keterangan" class="form-control" rows="3" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Ajukan Pengembalian</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
