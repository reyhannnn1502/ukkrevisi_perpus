@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Profile Anggota Perpustakaan</h5>
                </div>
                <div class="card-body">
                    @if($anggota)
                        <div class="text-center mb-4">
                            @if($anggota->foto)
                                <img src="{{ asset('avatars/' . $anggota->foto) }}" 
                                     class="rounded-circle mb-3" 
                                     style="width: 150px; height: 150px; object-fit: cover;"
                                     onerror="this.src='{{ asset('images/default-avatar.png') }}'"
                                     alt="Foto Profile">
                            @else
                                <img src="{{ asset('images/default-avatar.png') }}" 
                                     class="rounded-circle mb-3"
                                     style="width: 150px; height: 150px; object-fit: cover;"
                                     alt="Default Avatar">
                            @endif
                            
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#updateFotoModal">
                                    <i class="fas fa-camera"></i> Ganti Foto
                                </button>
                            </div>
                            
                            <h4>{{ $anggota->nama_anggota }}</h4>
                            <p class="text-muted">{{ $anggota->kode_anggota }}</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary">Informasi Pribadi</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td>Tempat, Tanggal Lahir</td>
                                        <td>: {{ $anggota->tempat }}, {{ \Carbon\Carbon::parse($anggota->tgl_lahir)->format('d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>: {{ $anggota->alamat }}</td>
                                    </tr>
                                    <tr>
                                        <td>No. Telepon</td>
                                        <td>: {{ $anggota->no_telp }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>: {{ $anggota->email }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary">Informasi Keanggotaan</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td>Jenis Anggota</td>
                                        <td>: {{ $anggota->jenisAnggota->jenis_anggota }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Daftar</td>
                                        <td>: {{ \Carbon\Carbon::parse($anggota->tgl_daftar)->format('d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Masa Aktif</td>
                                        <td>: {{ \Carbon\Carbon::parse($anggota->masa_aktif)->format('d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>: 
                                            @if(\Carbon\Carbon::now()->lte($anggota->masa_aktif))
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <p class="mb-0">Anda belum terdaftar sebagai anggota perpustakaan. 
                                <a href="{{ route('anggota.create') }}">Daftar sekarang!</a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update Foto -->
<div class="modal fade" id="updateFotoModal" tabindex="-1" aria-labelledby="updateFotoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('anggota.updateFoto') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="modal-header">
                    <h5 class="modal-title" id="updateFotoModalLabel">Ganti Foto Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div class="form-group">
                        <label for="foto">Pilih Foto Baru</label>
                        <input type="file" class="form-control" id="foto" name="foto" required accept="image/*">
                        <small class="text-muted">Format: JPG, JPEG, PNG (Max: 2MB)</small>
                    </div>
                    
                    <!-- Preview foto yang akan diupload -->
                    <div class="mt-3 text-center d-none" id="imagePreview">
                        <img src="" alt="Preview" style="max-width: 200px; max-height: 200px;">
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Preview foto sebelum upload
    document.getElementById('foto').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        const file = e.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.querySelector('img').src = e.target.result;
            preview.classList.remove('d-none');
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection

@section('styles')
<style>
    .card {
        border-radius: 15px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    .card-header {
        border-radius: 15px 15px 0 0 !important;
    }
    .table td {
        padding: 0.5rem;
    }
</style>
@endsection