@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Tambah Pustaka</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.pustaka.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="judul_pustaka">Judul Pustaka</label>
                            <input type="text" class="form-control" id="judul_pustaka" name="judul_pustaka" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="isbn">ISBN</label>
                            <input type="text" class="form-control" id="isbn" name="isbn" required>
                        </div>

                        <div class="form-group">
                            <label for="id_ddc">Kategori DDC</label>
                            <select class="form-control" id="id_ddc" name="id_ddc" required>
                                @foreach($ddcs as $ddc)
                                    <option value="{{ $ddc->id_ddc }}">{{ $ddc->nama_ddc }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="id_format">Format</label>
                            <select class="form-control" id="id_format" name="id_format" required>
                                @foreach($formats as $format)
                                    <option value="{{ $format->id_format }}">{{ $format->nama_format }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_penerbit">Penerbit</label>
                            <select class="form-control" id="id_penerbit" name="id_penerbit" required>
                                @foreach($penerbits as $penerbit)
                                    <option value="{{ $penerbit->id_penerbit }}">{{ $penerbit->nama_penerbit }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="id_pengarang">Pengarang</label>
                            <select class="form-control" id="id_pengarang" name="id_pengarang" required>
                                @foreach($pengarangs as $pengarang)
                                    <option value="{{ $pengarang->id_pengarang }}">{{ $pengarang->nama_pengarang }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tahun_terbit">Tahun Terbit</label>
                            <input type="text" class="form-control" id="tahun_terbit" name="tahun_terbit" required>
                        </div>

                        <div class="form-group">
                            <label for="keyword">Kata Kunci</label>
                            <input type="text" class="form-control" id="keyword" name="keyword" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="abstraksi">Abstraksi</label>
                            <textarea class="form-control" id="abstraksi" name="abstraksi" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="gambar">Gambar Buku</label>
                            <input type="file" class="form-control" id="gambar" name="gambar">
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="harga_buku">Harga Buku</label>
                                    <input type="number" class="form-control" id="harga_buku" name="harga_buku" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="denda_terlambat">Denda Terlambat</label>
                                    <input type="number" class="form-control" id="denda_terlambat" name="denda_terlambat">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="denda_hilang">Denda Hilang</label>
                                    <input type="number" class="form-control" id="denda_hilang" name="denda_hilang">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="kondisi_buku">Kondisi Buku</label>
                            <select class="form-control" id="kondisi_buku" name="kondisi_buku" required>
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>
                                <option value="Hilang">Hilang</option>
                            </select>
                        </div>
                        <input type="hidden" name="fp" value="1">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.pustaka.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection