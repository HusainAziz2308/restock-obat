<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\AdminExportController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::redirect('/', '/home');
Route::get('/home', [HomeController::class, 'index'])->name('home.index');

/*
|--------------------------------------------------------------------------
| PERKENALAN
|--------------------------------------------------------------------------
*/
Route::get('/husain', function () {
    return view('profil.husain');
});

Route::get('/nukhi', function () {
    return view('profil.nukhi');
});

Route::get('/affani', function () {
    return view('profil.affani');
});


/*
|--------------------------------------------------------------------------
| HALAMAN STATIS
|--------------------------------------------------------------------------
*/
Route::view('/contact', 'pages.contact')->name('contact.index');
Route::view('/katalog', 'pages.katalog')->name('katalog.index');



/*
|--------------------------------------------------------------------------
| KATALOG (UTAMA)
|--------------------------------------------------------------------------
*/
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');

/*
|--------------------------------------------------------------------------
| PROFIL
|--------------------------------------------------------------------------
*/
Route::get('/about', [ProfilController::class, 'index'])->name('about.index');
Route::get('/about/{nim}', [ProfilController::class, 'show'])->name('about.show');


/*
|--------------------------------------------------------------------------
| OPTIONAL (ALIAS OBAT)
|--------------------------------------------------------------------------
*/
Route::redirect('/obat', '/katalog');
Route::get('/obat/{id}', [KatalogController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Google Authentication
|--------------------------------------------------------------------------
*/
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

/*
|--------------------------------------------------------------------------
| EXPORT LAPORAN (auth required)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('admin/export')->name('admin.export.')->group(function () {
    Route::get('/medicines', [AdminExportController::class, 'medicines'])->name('medicines');
    Route::get('/restocks', [AdminExportController::class, 'restocks'])->name('restocks');
    Route::get('/stock-outs', [AdminExportController::class, 'stockOuts'])->name('stock-outs');
    Route::get('/stock-movements', [AdminExportController::class, 'stockMovements'])->name('stock-movements');
});
