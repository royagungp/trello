<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\NaspadController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [UserController::class, 'login'])->name('login');
// verifikasi
Route::post('/login/auth', [UserController::class, 'loginAuth'])->name('login.auth');

Route::middleware(['isLogin'])->group(function() {
    // untuk logout
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    // url : kebab case, name : snack case, controller&function : camel case
    Route::get('/landing-page', [LandingPageController::class, 'index'])->name('landing_page');

    // mengelola data naspads
    Route::get('/naspads', [NaspadController::class, 'index'])->name('naspads');
    Route::get('/naspads/add', [NaspadController::class, 'create'])->name('naspads.add');
    Route::post('/naspads/add', [NaspadController::class, 'store'])->name('naspads.add.store');
    // /{namaPathDinamis} : path dinamis, nilainya akan berubah-ubah (harus diisi ketika mengakses route) -> ketika akses di blade nya menjadi href="{{ route('name_route', $isiPathDinamis) }}" atau action="{{ route('name_route', $isiPathDinamis) }}"
    // fungsi path dinamis : spesifikasi data yg akan diproses
    Route::delete('/naspads/delete/{id}', [NaspadController::class, 'destroy'])->name('naspads.delete');
    // edit pake {id} karna perlu spesifikasi data mana yg mau diedit
    Route::get('/naspads/edit/{id}', [NaspadController::class, 'edit'])->name('naspads.edit');
    Route::patch('/naspads/edit/{id}', [NaspadController::class, 'update'])->name('naspads.edit.update');
    // Route::get('naspads/stock', [NaspadController::class, 'updateEdit'])->name('medicine.stok.edit'); 
    Route::put('/naspads/update-porsi/{id}', [NaspadController::class, 'porsiEdit'])->name('naspad.porsi.edit');

    // halaman login
    // Route::get('/login', [UserController::class, 'pagesLogin'])->name('login');
    Route::get('/akun', [UserController::class, 'index'])->name('akun');
    Route::get('akun/add', [UserController::class, 'create'])->name('akun.add');
    Route::post('akun/add', [UserController::class, 'store'])->name('akun.add.store');
    Route::delete('akun/delete/{id}', [UserController::class, 'destroy'])->name('akun.delete');
    Route::get('akun/edit/{id}', [UserController::class, 'edit'])->name('akun.edit');
    Route::patch('akun/edit/{id}', [UserController::class, 'update'])->name('akun.edit.update');
});



