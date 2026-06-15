<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
// Route::get('/', function () {
//     return view('welcome');
// })->name('home.index');
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
Route::view('/about', 'pages.about')->name('about.index');
Route::view('/contact', 'kontak')->name('contact.index');
Route::view('/katalog', 'pages.katalog')->name('katalog.index');
Route::view('/promo', 'pages.promo')->name('promo.index');


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
