<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryResource extends Resource
{
    use HasFactory;
    protected $primaryKey = 'category_id';

    protected $fillable = ['name', 'slug', 'description'];

    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Section::make('Informasi Kategori')
                    ->description('Isi detail kategori obat di sini.')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('name')
                            ->label('Nama Kategori')
                            ->placeholder('Contoh: Obat Bebas, Obat Keras, Herbal, dll.') // Ini placeholder-nya
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, $set) =>
                                $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),

                        \Filament\Forms\Components\TextInput::make('slug')
                            ->label('Slug (Otomatis)')
                            ->placeholder('obat-keras') // Contoh format slug
                            ->disabled()
                            ->dehydrated()
                            ->required(),

                        \Filament\Forms\Components\Textarea::make('description')
                            ->label('Keterangan')
                            ->placeholder('Tuliskan deskripsi singkat mengenai kategori ini...') // Placeholder textarea
                            ->columnSpanFull(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('name')
                ->label('Nama Kategori')
                ->searchable()
                ->sortable(),

            \Filament\Tables\Columns\TextColumn::make('slug')
                ->label('Slug')
                ->badge()
                ->color('gray'),

            \Filament\Tables\Columns\TextColumn::make('description')
                ->label('Keterangan')
                ->limit(50)
                ->placeholder('Tidak ada keterangan'),

            \Filament\Tables\Columns\TextColumn::make('created_at')
                ->label('Dibuat Pada')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Tables\Actions\EditAction::make(),
                \Filament\Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\BulkActionGroup::make([
                    \Filament\Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
