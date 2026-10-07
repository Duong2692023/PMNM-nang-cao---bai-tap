<?php

use App\Http\Controllers\LopHocController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SinhVienController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/lophoc');
});
Route::get('/layoutmaster', function () {
    return view('layoutmaster');
});

Route::patch('sinhvien/{sinhvien}/toggle-status', [SinhVienController::class, 'toggleStatus'])
    ->name('sinhvien.toggle-status');

// Route::get('/sinhvien', [SinhVienController::class, 'index']);
// Route::get('/sinhvien/show/{id?}}', [SinhVienController::class, 'show'])->where('id', '[0-9]+');
// Route::get('/sinhvien/create', [SinhVienController::class, 'create']);
// Route::post('/sinhvien/store', [SinhVienController::class, 'store'])->name('sinhvien.store');

// Route::prefix('sinhvien')->group(function () {
//     Route::get('/', [SinhVienController::class, 'index']);
//     Route::get('/show/{id?}}', [SinhVienController::class, 'show'])->where('id', '[0-9]+');
//     Route::get('/create', [SinhVienController::class, 'create']);
//     Route::post('/store', [SinhVienController::class, 'store'])->name('sinhvien.store');
// });

Route::resource('sinhvien', SinhVienController::class);
Route::resource('lophoc', LopHocController::class);
// Menu không cần trang chi tiết -> bỏ route show
Route::resource('menu', MenuController::class)->except('show');
//
