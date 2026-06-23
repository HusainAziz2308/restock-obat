<?php

namespace App\Filament\Pages;
use \App\Models\User;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public static function canAccess(): bool
    {
        $user = auth()->user();
        
        return $user->hasAnyRole(['Owner', 'Manager']);
    }
}