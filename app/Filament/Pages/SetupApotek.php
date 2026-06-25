<?php

namespace App\Filament\Pages;

use App\Models\Pharmacy;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class SetupApotek extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected string $view = 'filament.pages.setup-apotek';

    protected static ?string $title = 'Setup Apotek';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $slug = 'setup-apotek';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Informasi Apotek')
                ->description('Silakan lengkapi data apotek Anda untuk memulai.')
                ->schema([
                    TextInput::make('name')
                        ->label('Nama Apotek')
                        ->required()
                        ->maxLength(255),
                ])
        ])->statePath('data');
    }

    public function save(): void
    {
        $formData = $this->form->getState();
        $user = Auth::user();

        if (! $user) {
            return;
        }

        $pharmacy = Pharmacy::create([
            'name' => $formData['name'],
            'status' => 'active',
        ]);

        $user->update(['pharmacy_id' => $pharmacy->id]);

        Notification::make()
            ->title('Apotek berhasil disiapkan!')
            ->success()
            ->send();

        $this->redirect('/admin');
    }
}