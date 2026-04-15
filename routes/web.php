<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\KatalogController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home.index');


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
Route::view('/about', 'pages.about')->name('about.index');
Route::view('/contact', 'pages.contact')->name('contact.index');
Route::view('/faq', 'pages.faq')->name('faq.index');
Route::view('/panduan', 'pages.panduan')->name('panduan.index');
Route::view('/promo', 'pages.promo')->name('promo.index');


/*
|--------------------------------------------------------------------------
| KATALOG (UTAMA)
|--------------------------------------------------------------------------
*/
Route::prefix('katalog')->group(function () {

    Route::get('/', [KatalogController::class, 'index'])->name('katalog.index');

    Route::get('/create', function () {
        return view('produk.create');
    })->name('katalog.create');

    Route::get('/search', [KatalogController::class, 'search'])->name('katalog.search');

    Route::get('/kategori/{kategori}', [KatalogController::class, 'kategori'])->name('katalog.kategori');

    Route::get('/{id}', [KatalogController::class, 'show'])->name('katalog.show');

});


/*
|--------------------------------------------------------------------------
| PROFIL
|--------------------------------------------------------------------------
*/
Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
Route::get('/profil/{nim}', [ProfilController::class, 'show'])->name('profil.show');


/*
|--------------------------------------------------------------------------
| OPTIONAL (ALIAS OBAT)
|--------------------------------------------------------------------------
*/
Route::get('/obat', [KatalogController::class, 'index']);
Route::get('/obat/{id}', [KatalogController::class, 'show']);