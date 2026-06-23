<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                
                TextInput::make('email')
                    ->label('Alamat Email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create'),

                Select::make('roles')
                    ->label('Peran/Jabatan')
                    ->relationship('roles', 'name')
                    ->preload()
                    ->multiple()
                    ->required(),

                TextInput::make('company_id')
                    ->default(auth()->user()->company_id)
                    ->hidden(),
            ]);
    }
}
