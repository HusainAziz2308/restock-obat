<?php

namespace App\Filament\Pages;
use \App\Models\User;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    // protected static string $routePath = 'dashboard';
    // public static function canAccess(): bool
    // {
    //     $user = auth()->user();
        
    //     return $user->hasAnyRole(['Owner', 'Manager']);
    // }

    public function mount()
    {
        $user = Auth::user();
        
        // Jika bukan Owner/Manager, tendang ke Beranda.
        // Jika dia Owner/Manager, biarkan kode ini dilewati dan Dashboard tetap tampil.
        if (!$user->hasAnyRole(['Owner', 'Manager'])) {
            return redirect()->to('/admin/beranda');
        }
    }
}