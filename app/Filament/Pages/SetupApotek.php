<?php

namespace App\Filament\Pages;

use App\Models\Pharmacy;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;

class SetupApotek extends RegisterTenant
{

    public static function getLabel(): string
    {
        return 'Setup Apotek';
    }

    public function form(Schema $form): Schema
    {
        return $form->components([
            Section::make('Informasi Apotek')
                ->description('Silakan lengkapi data apotek Anda untuk memulai.')
                ->components([ 
                    TextInput::make('name')
                        ->label('Nama Apotek')
                        ->required()
                        ->maxLength(255),
                ])
        ]);
    }

    protected function handleRegistration(array $data): Pharmacy
    {
        $pharmacy = Pharmacy::create([
            'name' => $data['name'],
            'status' => 'active',
        ]);

        auth()->user()->update(['pharmacy_id' => $pharmacy->id]);

        return $pharmacy;
    }
}