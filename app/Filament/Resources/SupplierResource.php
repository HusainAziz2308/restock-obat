<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\Pages;
use App\Models\Supplier;
use BackedEnum;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-truck';

    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Supplier';

    protected static ?string $modelLabel = 'Supplier';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informasi Supplier')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Supplier')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('PT Kimia Farma, CV Sumber Sehat, dll'),

                        TextInput::make('contact_person')
                            ->label('Kontak Person')
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->label('No. Telepon')
                            ->tel()
                            ->maxLength(50),

                        TextInput::make('address')
                            ->label('Alamat')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Textarea::make('notes')
                            ->label('Catatan')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Supplier')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('contact_person')
                    ->label('Kontak')
                    ->placeholder('-'),
                TextColumn::make('phone')
                    ->label('Telepon')
                    ->placeholder('-'),
                TextColumn::make('address')
                    ->label('Alamat')
                    ->limit(40)
                    ->placeholder('-'),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }
}
