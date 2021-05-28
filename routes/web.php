<?php
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\CetakController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\RabController;
use App\Http\Controllers\RabTempController;
use App\Http\Controllers\RestokController;
use App\Http\Controllers\UserManagementController;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'auth'])->name('/');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// admin

Route::group(['middleware' => ['role:admin']], function () {
    // user management
    Route::get('/user/{jenis}', [UserManagementController::class, 'index'])->name('user.index');
    Route::post('/user/store', [UserManagementController::class, 'store'])->name('user.store');
    Route::post('/user/edit', [UserManagementController::class, 'edit'])->name('user.edit');
    Route::post('/user/update', [UserManagementController::class, 'update'])->name('user.update');
    Route::post('/user/hapus', [UserManagementController::class, 'hapus'])->name('user.hapus');
    Route::post('/user/resetpw', [UserManagementController::class, 'resetpw'])->name('user.resetpw');

     // kelola barang
     Route::post('/barang/store', [BarangController::class, 'store'])->name('barang.store');
     Route::get('/barang/edit/{id}', [BarangController::class, 'edit'])->name('barang/edit');
     Route::POST('/barang/update/', [BarangController::class, 'update'])->name('barang.update');
     Route::POST('/barang/hapus/', [BarangController::class, 'hapus'])->name('barang.hapus');

   
    // kelola kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
    Route::POST('/kategori/edit', [KategoriController::class, 'update'])->name('kategori.update');
    Route::POST('/kategori/hapus/', [KategoriController::class, 'hapus'])->name('kategori.hapus');

    

    // kelola ajax
    Route::get('/GetBarangByKategori/{id}', [AjaxController::class, 'GetBarangByKategori'])->name('GetBarangByKategori');


});

Route::group(['middleware' => ['role:admin|pegawai']], function () {

    // barang Peminjaman
    Route::post('peminjaman/store', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/edit/{id}', [PeminjamanController::class, 'edit'])->name('peminjaman/edit');
    Route::POST('/peminjaman/update/', [PeminjamanController::class, 'update'])->name('peminjaman.update');
    Route::POST('/peminjaman/hapus/', [PeminjamanController::class, 'hapus'])->name('peminjaman.hapus');

    // barang pengembalian
    Route::get('/pengembalian/edit/{id}', [PengembalianController::class, 'edit'])->name('pengembalian/edit');
    Route::POST('/pengembalian/update/', [PengembalianController::class, 'update'])->name('pengembalian.update');
  
    // kelola restok barang 
    Route::post('restok/store', [RestokController::class, 'store'])->name('restok.store');
    Route::get('/restok/edit/{id}', [RestokController::class, 'edit'])->name('restok/edit');
    Route::POST('/restok/update/', [RestokController::class, 'update'])->name('restok.update');
    Route::POST('/restok/terima/', [RestokController::class, 'terima'])->name('restok.terima');
    Route::POST('/restok/hapus/', [RestokController::class, 'hapus'])->name('restok.hapus');
});

Route::group(['middleware' => ['role:pegawai|admin|pimpinan']], function () {  
    // barang peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    // barang pengembalian
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
    // kelola barang index
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    // kelola restok barang 
    Route::get('/restok', [RestokController::class, 'index'])->name('restok.index');
    // kelola cetak
    Route::post('/cetak/cetak', [CetakController::class, 'cetak'])->name('cetak.cetak');
});

Route::get('/getBarangById/{id}', [BarangController::class, 'getBarangById'])->name('getBarangById');