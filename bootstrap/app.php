<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request; // <-- 1. WAJIB IMPORT INI BIAR AGAR KODE REQUEST DI BAWAH JALAN
use App\Providers\Filament\AdminPanelProvider;
use App\Http\Middleware\EnsurePharmacyIsSetup;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(fn() => route('filament.admin.auth.login'));

        $middleware->web(append: [
            EnsurePharmacyIsSetup::class,
        ]);

        // 2. DIUBAH MENJADI trustProxies (TANPA 'ED') MENGGUNAKAN NAMED ARGUMENTS
        $middleware->trustProxies(
            at: '*',
            headers: Request::HEADER_X_FORWARDED_FOR |
                Request::HEADER_X_FORWARDED_HOST |
                Request::HEADER_X_FORWARDED_PORT |
                Request::HEADER_X_FORWARDED_PROTO |
                Request::HEADER_X_FORWARDED_AWS_ELB
        );
    })
    ->withProviders([
        AdminPanelProvider::class,
    ])
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

// 3. KODE CLASS TRUSTPROXIES MANUAL DI BAWAH SINI SUDAH DIHAPUS KARENA SUDAH DIWAKILI DI ATAS
