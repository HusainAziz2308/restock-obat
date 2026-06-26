<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use App\Filament\Pages\Beranda;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use \Spatie\Permission\Middleware\PermissionMiddleware;
use \App\Http\Middleware\EnsurePharmacyIsSetup;
use Filament\Navigation\MenuItem;
use App\Models\Pharmacy;
use \App\Filament\Pages\SetupApotek;
use \App\Filament\Pages\EditApotek;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->homeUrl('/admin')
            ->tenant(Pharmacy::class) 
            ->tenantRegistration(SetupApotek::class)
            ->tenantProfile(EditApotek::class)
            ->userMenuItems([
                MenuItem::make()
                    ->label(fn() => 'Role: ' . (auth()->user()?->roles->pluck('name')->implode(', ') ?: 'Tidak ada'))
                    ->icon('heroicon-o-identification')
                    ->url('#'),
            ])
            ->login()
            ->registration()
            ->passwordReset()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->brandLogo(asset('images/favicon.svg'))
            ->brandLogoHeight('3rem')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
                Beranda::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
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
}
