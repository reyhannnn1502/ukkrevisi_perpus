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
                                            <div class="mb-3">
                                                <label class="form-label">Kondisi Buku</label>
                                                <select name="kondisi_buku" class="form-control" id="kondisiBuku{{ $transaksi->id_transaksi }}" required>
                                                    <option value="baik">Baik</option>
                                                    <option value="rusak">Rusak</option>
                                                    <option value="hilang">Hilang</option>
                                                </select>
                                            </div>
                                            <div class="mb-3" id="rusakDetails{{ $transaksi->id_transaksi }}" style="display: none;">
                                                <label class="form-label">Detail Kerusakan</label>
                                                <select name="detail_rusak" class="form-control" id="detailRusak{{ $transaksi->id_transaksi }}">
                                                    <option value="ringan">Rusak Ringan</option>
                                                    <option value="berat">Rusak Berat</option>
                                                </select>
                                            </div>
                                            <div class="mb-3" id="denda{{ $transaksi->id_transaksi }}" style="display: none;">
                                                <label class="form-label">Denda</label>
                                                <input type="text" class="form-control" id="dendaAmount{{ $transaksi->id_transaksi }}" readonly>
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
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const kondisiBuku = document.getElementById('kondisiBuku{{ $transaksi->id_transaksi }}');
                                const detailRusak = document.getElementById('detailRusak{{ $transaksi->id_transaksi }}');
                                const rusakDetails = document.getElementById('rusakDetails{{ $transaksi->id_transaksi }}');
                                const denda = document.getElementById('denda{{ $transaksi->id_transaksi }}');
                                const dendaAmount = document.getElementById('dendaAmount{{ $transaksi->id_transaksi }}');
                                const bayarButton = document.getElementById('bayarButton{{ $transaksi->id_transaksi }}');

                                kondisiBuku.addEventListener('change', function () {
                                    if (this.value === 'rusak') {
                                        rusakDetails.style.display = 'block';
                                        denda.style.display = 'block';
                                        updateDenda();
                                        bayarButton.style.display = 'block';
                                    } else if (this.value === 'hilang') {
                                        rusakDetails.style.display = 'none';
                                        denda.style.display = 'block';
                                        dendaAmount.value = 'Rp ' + ({{ $transaksi->pustaka->denda_hilang }}).toLocaleString();
                                        bayarButton.style.display = 'block';
                                    } else {
                                        rusakDetails.style.display = 'none';
                                        denda.style.display = 'none';
                                        bayarButton.style.display = 'none';
                                    }
                                });

                                detailRusak.addEventListener('change', updateDenda);

                                function updateDenda() {
                                    const dendaRusak = {{ $transaksi->pustaka->denda_rusak }};
                                    if (detailRusak.value === 'ringan') {
                                        dendaAmount.value = 'Rp ' + (dendaRusak * 0.5).toLocaleString();
                                    } else if (detailRusak.value === 'berat') {
                                        dendaAmount.value = 'Rp ' + (dendaRusak).toLocaleString();
                                    }
                                }
                            });
                        </script>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
