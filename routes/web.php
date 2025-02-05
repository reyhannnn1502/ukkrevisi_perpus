<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\DDCController;
use App\Http\Controllers\FormatController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\PengarangController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\JenisAnggotaController;
use App\Http\Controllers\PustakaController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PerpustakaanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return view('auth.login');
});

require __DIR__.'/auth.php';

Auth::routes();

/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:user'])->group(function () {
  
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/book/{id}', [HomeController::class, 'showBook'])->name('book.show');
    
    // Tambahkan route untuk anggota
    Route::get('/anggota/register', [AnggotaController::class, 'create'])->name('anggota.create');
    Route::post('/anggota/store', [AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('/anggota/profile', [AnggotaController::class, 'profile'])->name('anggota.profile');
    Route::put('/anggota/update', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::put('/anggota/update-foto', [AnggotaController::class, 'updateFoto'])->name('anggota.updateFoto');

    Route::get('/book/{id}/borrow', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');

    Route::get('/books/search', [PustakaController::class, 'search'])->name('books.search');

    // Catalog route
    Route::get('/books/catalog', [PustakaController::class, 'catalog'])->name('books.catalog');
    
    // Borrowing history route
    Route::get('/borrowing/history', [TransaksiController::class, 'userHistory'])->name('user.borrowing.history');
    
    // Favorites routes
    Route::get('/favorites', [PustakaController::class, 'favorites'])->name('user.favorites');
    Route::post('/favorites/{book}', [PustakaController::class, 'toggleFavorite'])->name('user.favorites.toggle');

    // Route untuk peminjaman buku
    Route::get('/transaksi/create/{id}', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/history', [TransaksiController::class, 'userHistory'])->name('user.borrowing.history');

    Route::get('/user/return-request/{id}', [TransaksiController::class, 'showReturnRequest'])->name('user.return.request');
    Route::put('/user/return-request/{id}', [TransaksiController::class, 'submitReturnRequest'])->name('user.request.pengembalian');
});
  
/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {
  
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');

    Route::prefix('admin')->group(function () {
        Route::resource('rak', RakController::class)->names([
            'index' => 'admin.rak.index',
            'create' => 'admin.rak.create',
            'store' => 'admin.rak.store',
            'edit' => 'admin.rak.edit',
            'update' => 'admin.rak.update',
            'destroy' => 'admin.rak.destroy'
        ]);
    });

    Route::prefix('admin')->group(function () {
        Route::resource('ddc', DDCController::class)->names([
            'index' => 'admin.ddc.index',
            'create' => 'admin.ddc.create',
            'store' => 'admin.ddc.store',
            'edit' => 'admin.ddc.edit',
            'update' => 'admin.ddc.update',
            'destroy' => 'admin.ddc.destroy'
        ]);
    });

    Route::prefix('admin')->group(function () {
        Route::resource('format', FormatController::class)->names([
            'index' => 'admin.format.index',
            'create' => 'admin.format.create',
            'store' => 'admin.format.store',
            'edit' => 'admin.format.edit',
            'update' => 'admin.format.update',
            'destroy' => 'admin.format.destroy'
        ]);
    });

    Route::prefix('admin')->group(function () {
        // ... route lainnya
        Route::resource('penerbit', PenerbitController::class)->names([
            'index' => 'admin.penerbit.index',
            'create' => 'admin.penerbit.create',
            'store' => 'admin.penerbit.store',
            'edit' => 'admin.penerbit.edit',
            'update' => 'admin.penerbit.update',
            'destroy' => 'admin.penerbit.destroy'
        ]);
    });

    Route::prefix('admin')->group(function () {
        // ... route lainnya
        Route::resource('pengarang', PengarangController::class)->names([
            'index' => 'admin.pengarang.index',
            'create' => 'admin.pengarang.create',
            'store' => 'admin.pengarang.store',
            'edit' => 'admin.pengarang.edit',
            'update' => 'admin.pengarang.update',
            'destroy' => 'admin.pengarang.destroy'
        ]);
    });

    Route::prefix('admin')->group(function () {
        Route::resource('jenis-anggota', JenisAnggotaController::class)->names([
            'index' => 'admin.jenis-anggota.index',
            'create' => 'admin.jenis-anggota.create',
            'store' => 'admin.jenis-anggota.store',
            'edit' => 'admin.jenis-anggota.edit',
            'update' => 'admin.jenis-anggota.update',
            'destroy' => 'admin.jenis-anggota.destroy'
        ]);
    });

    Route::prefix('admin')->group(function () {
        Route::resource('pustaka', PustakaController::class)->names([
            'index' => 'admin.pustaka.index',
            'create' => 'admin.pustaka.create',
            'store' => 'admin.pustaka.store',
            'edit' => 'admin.pustaka.edit',
            'update' => 'admin.pustaka.update',
            'destroy' => 'admin.pustaka.destroy'
        ]);
    });

    Route::prefix('admin')->group(function () {
        Route::resource('transaksi', TransaksiController::class)->names([
            'index' => 'admin.transaksi.index',
            'create' => 'admin.transaksi.create',
            'store' => 'admin.transaksi.store',
        ]);
        Route::put('transaksi/{id}/pengembalian', [TransaksiController::class, 'pengembalian'])
            ->name('admin.transaksi.pengembalian');
        Route::put('admin/transaksi/{id}/approve', [TransaksiController::class, 'approve'])
            ->name('admin.transaksi.approve');
        Route::put('admin/transaksi/{id}/reject', [TransaksiController::class, 'reject'])
            ->name('admin.transaksi.reject');
    });

    Route::get('/admin/transaksi', [TransaksiController::class, 'index'])->name('admin.transaksi.index');

    // Admin Profile Routes
    Route::prefix('admin/profile')->group(function () {
        Route::get('/', [AdminController::class, 'profileAdmin'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::post('/', [ProfileController::class, 'store'])->name('admin.profile.store');
    });

    Route::get('/admin/perpustakaan', [PerpustakaanController::class, 'index'])
        ->name('admin.perpustakaan.index');
    Route::post('/admin/perpustakaan', [PerpustakaanController::class, 'store'])
        ->name('admin.perpustakaan.store');
    Route::put('/admin/perpustakaan/{id}', [PerpustakaanController::class, 'update'])
        ->name('admin.perpustakaan.update');
});

// Route untuk user
Route::get('/perpustakaan', [PerpustakaanController::class, 'show'])
    ->name('perpustakaan.show');

// Buat route untuk membuat symbolic link jika belum ada
Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
    return 'Storage link has been created';
});



