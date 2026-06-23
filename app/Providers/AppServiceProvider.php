<?php

namespace App\Providers;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use App\Filament\Pages\Dashboard;
use Filament\Navigation\MenuItem;

class AppServiceProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->userMenuItems([
                MenuItem::make()
                    ->label(fn() => 'Role: ' . (auth()->user()->roles->pluck('name')->implode(', ') ?: 'Tidak ada'))
                    ->icon('heroicon-o-identification')
                    ->url('#'),
            ])
            ->path('admin')
            ->login()          // Route /admin/login
            ->registration()   // Route /admin/register
            ->colors([
                'primary' => Color::Amber,
            ])
            ->brandLogo(asset('images/favicon.svg')) // lokasi logo
            ->brandLogoHeight('3rem')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }

    public function boot(): void
    {
        View::share('sliders', [
            [
                'image' => 'https://images.unsplash.com/photo-1586015555751-63bb77f4322a?q=80&w=1600&auto=format&fit=crop',
                'title' => 'Manajemen Inventaris Obat Modern',
                'subtitle' => 'Pantau ketersediaan stok dan kelola restock obat secara real-time dengan akurasi tinggi.'
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?q=80&w=1600&auto=format&fit=crop',
                'title' => 'Dashboard Realtime',
                'subtitle' => 'Menampilkan dashboard barang masuk dan keluar secara realtime'
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1471864190281-a93a3070b6de?q=80&w=1600&auto=format&fit=crop',
                'title' => 'Sistem Management Berbasis Cloud',
                'subtitle' => 'Akses dashboard manajemen apotek kapan saja dan di mana saja dengan aman.'
            ]
        ]);

        // Tombol login google
        // Halaman Login
        FilamentView::registerRenderHook(
            PanelsRenderHook::AUTH_LOGIN_FORM_AFTER,
            fn(): string => View::make('components.google-login')->render()
        );

        // Halaman Register
        FilamentView::registerRenderHook(
            PanelsRenderHook::AUTH_REGISTER_FORM_AFTER,
            fn(): string => View::make('components.google-login')->render()
        );
    }
}
