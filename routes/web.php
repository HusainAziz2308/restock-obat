<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\KatalogController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
// Route::get('/', function () {
//     return view('welcome');
// })->name('home.index');
Route::redirect('/', '/home');

Route::get('/home', function () {
    return view('home');
});

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
    Route::get('/create', [KatalogController::class, 'create'])->name('katalog.create');
    Route::post('/store', [KatalogController::class, 'store'])->name('katalog.store');
    Route::get('/search', [KatalogController::class, 'search'])->name('katalog.search');
    Route::get('/kategori/{kategori}', [KatalogController::class, 'kategori'])->name('katalog.kategori');
    Route::get('/{id}/edit', [KatalogController::class, 'edit'])->name('katalog.edit');
    Route::put('/{id}', [KatalogController::class, 'update'])->name('katalog.update');
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
Route::redirect('/obat', '/katalog');
Route::get('/obat/{id}', [KatalogController::class, 'show']);
