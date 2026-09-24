
<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenanamanController;
use App\Http\Controllers\PerawatanApiController;
use App\Http\Controllers\PerawatanController;
use App\Http\Controllers\PengadaanBibitController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PemanenanController;
use App\Http\Controllers\BibitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ManajemenAkunController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\ProfileController;

//untk menampilkan halaman depan
Route::view('/', 'halaman_depan.index'); 

//berfungsi untuk menampilkan halaman login dan login proses
Route::get('/sesi', [AuthController::class, 'index'])->name('login');
Route::post('/sesi', [AuthController::class, 'login'])->name('auth.login');  

//route untuk mencetak laporan pada masing-masing fitur
Route::get('/penanaman/cetak', [PenanamanController::class, 'cetak'])
    ->name('penanaman.cetak');  

Route::get('/pengadaan_bibit/cetak', [PengadaanBibitController::class, 'cetak'])
    ->name('pengadaan_bibit.cetak');

Route::get('/pemanenan/cetak', [PemanenanController::class, 'cetak'])
    ->name('pemanenan.cetak');

Route::get('/perawatan/cetak', [PerawatanController::class, 'cetak'])
    ->name('perawatan.cetak');

Route::get('/penjualan/cetak', [PenjualanController::class, 'cetak'])
    ->name('penjualan.cetak');


//route middleware dan resource untuk fitur yg bisa diakses admin sekaligus user
Route::middleware(['auth', 'check_role:admin,user'])->group(function () {
    Route::resource('penanaman', PenanamanController::class);  
    Route::resource('perawatan', PerawatanController::class);
    Route::resource('pemanenan', PemanenanController::class);
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// API routes untuk perawatan
Route::prefix('api')->group(function () {
    Route::get('perawatan', [PerawatanApiController::class, 'index']);
    Route::post('perawatan', [PerawatanApiController::class, 'store']);
    Route::get('perawatan/{perawatan}', [PerawatanApiController::class, 'show']);
    Route::put('perawatan/{perawatan}', [PerawatanApiController::class, 'update']);
    Route::delete('perawatan/{perawatan}', [PerawatanApiController::class, 'destroy']);
});


//jka login terindikasi sebagai user(pegawai) maka akan diarahkan ke dashboard user
Route::middleware(['auth', 'check_role:user'])->group(function () {  
        Route::get('/poinakses/user/dashboard', [UserController::class, 'index'])
    ->name('user.dashboard');
});


//jka login terindikasi sebagai admin maka akan diarahkan ke dashboard admin
Route::middleware(['auth', 'check_role:admin'])->group(function () { 
    Route::get('/poinakses/admin/dashboard', [AdminController::class, 'index'])
    ->name('admin.dashboard');
    Route::get('/api/admin/stats', [AdminController::class, 'getStats'])
    ->name('admin.stats');
    Route::post('/clear-notifications', function() {
        session()->forget('notifications');
        return response()->json(['status' => 'cleared']);
    })->name('clear-notifications');

    Route::resource('penjualan', PenjualanController::class);
    Route::resource('pengadaan_bibit', PengadaanBibitController::class);
    Route::resource('bibit', BibitController::class);
    Route::resource('manajemen_akun', ManajemenAkunController::class);
    Route::resource('penggajian', PenggajianController::class);
    Route::get('/penggajian/cetak', [PenggajianController::class, 'cetak'])
        ->name('penggajian.cetak');
});



Route::post('/logout', function () {    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');
