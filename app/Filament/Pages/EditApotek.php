<?php

namespace App\Filament\Pages;

use Filament\Pages\Tenancy\EditTenantProfile;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;

class EditApotek extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Pengaturan Apotek';
    }

    public function form(Schema $form): Schema
    {
        return $form->components([
            Section::make('Ubah Informasi Apotek')
                ->description('Perbarui informasi dasar mengenai apotek Anda di sini.')
                ->components([
                    TextInput::make('name')
                        ->label('Nama Apotek')
                        ->required()
                        ->maxLength(255),
                ])
        ]);
    }
}