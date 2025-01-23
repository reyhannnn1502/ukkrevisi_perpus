@php
use Illuminate\Support\Facades\File;
@endphp

@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="row mb-4">
        <div class="col-12">
            @auth
                <div class="card">
                    <div class="card-body py-5">
                        <h2 class="display-5 text-primary mb-4">Cari Buku</h2>
                        <form action="" method="GET">
                            <div class="input-group input-group-lg">
                                <input type="text" class="form-control" name="keyword" 
                                    placeholder="Masukkan judul buku atau kata kunci..." 
                                    aria-label="Search books">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>
                            <div class="text-muted mt-2">
                                <small>Contoh: Novel, Sejarah, Teknologi, atau masukkan judul buku</small>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="card bg-primary text-white">
                    <div class="card-body py-5">
                        <h1 class="display-4">Selamat Datang di Perpustakaan Digital</h1>
                        <p class="lead">Temukan ribuan koleksi buku untuk menambah wawasan dan pengetahuan Anda</p>
                        <hr class="my-4">
                        <p>Belum menjadi anggota? Daftar sekarang!</p>
                        <a href="{{ route('anggota.create') }}" class="btn btn-light btn-lg">Daftar Anggota</a>
                    </div>
                </div>
            @endauth
        </div>
    </div>

    <!-- Quick Links Section -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-user-plus fa-3x mb-3 text-primary"></i>
                    <h5 class="card-title">Daftar Anggota</h5>
                    <p class="card-text">Bergabung menjadi anggota perpustakaan</p>
                    <a href="{{ route('anggota.create') }}" class="btn btn-primary">Daftar Sekarang</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-book fa-3x mb-3 text-primary"></i>
                    <h5 class="card-title">Katalog Buku</h5>
                    <p class="card-text">Jelajahi koleksi buku kami</p>
                    <a href="#" class="btn btn-primary">Lihat Katalog</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-history fa-3x mb-3 text-primary"></i>
                    <h5 class="card-title">Riwayat Peminjaman</h5>
                    <p class="card-text">Lihat riwayat peminjaman Anda</p>
                    <a href="#" class="btn btn-primary">Lihat Riwayat</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-bookmark fa-3x mb-3 text-primary"></i>
                    <h5 class="card-title">Buku Favorit</h5>
                    <p class="card-text">Koleksi buku favorit Anda</p>
                    <a href="#" class="btn btn-primary">Lihat Favorit</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Books Section -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-4">Buku Terbaru</h2>
        </div>
        @forelse($latestBooks as $book)
        <div class="col-md-2">
            <div class="card h-100">
                @php
                    $storagePath = storage_path('app/public/pustaka/' . $book->gambar);
                @endphp
                
                @if($book->gambar && File::exists($storagePath))
                    <img src="{{ asset('pustaka/' . $book->gambar) }}" 
                         class="card-img-top" alt="{{ $book->judul_pustaka }}"
                         style="height: 200px; object-fit: cover;">
                @else
                    <img src="{{ asset('images/no-image.png') }}" 
                         class="card-img-top" alt="No Image"
                         style="height: 200px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <h6 class="card-title text-truncate" title="{{ $book->judul_pustaka }}">
                        {{ $book->judul_pustaka }}
                    </h6>
                    <p class="card-text small text-muted mb-2">
                        {{ $book->pengarang->nama_pengarang }}
                    </p>
                    <a href="{{ route('book.show', $book->id_pustaka) }}" 
                       class="btn btn-primary btn-sm">Detail</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">
                Belum ada buku yang ditambahkan.
            </div>
        </div>
        @endforelse
    </div>

    <!-- Announcement Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Pengumuman</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-0">
                        <h5>Jam Operasional Perpustakaan</h5>
                        <p class="mb-0">Senin - Jumat: 08.00 - 16.00 WIB<br>
                        Sabtu: 09.00 - 13.00 WIB<br>
                        Minggu: Tutup</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
</style>
@endsection

