<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\User;

class Beranda extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-home';
    protected string $view = 'filament.pages.beranda';
    protected static ?string $navigationLabel = '   Beranda';
    
    protected static ?string $title = 'Beranda';
    
    // Angka -1 memastikan menu ini berada di urutan paling atas di atas menu Obat
    protected static ?int $navigationSort = -1; 

    // Atur agar halaman ini khusus untuk Apoteker dan Pegawai
    public static function canAccess(): bool
    {
        $user = auth()->user();
        
        return $user->hasAnyRole(['Apoteker', 'Pegawai']);
    }
    public function mount(): void
    {
        $user = auth()->user();

        // Jika yang masuk adalah Owner atau Manager, tendang balik ke Dashboard penuh grafik
        if ($user->hasAnyRole(['Owner', 'Manager'])) {
            redirect('/admin');
        }
    }
}
