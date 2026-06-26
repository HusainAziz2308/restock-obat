<?php

namespace App\Filament\Pages;

use App\Models\Pharmacy;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;

class SetupApotek extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';
    
    protected static string | array $middlewares = ['auth'];

    protected string $view = 'filament.pages.setup-apotek';

    protected static ?string $title = 'Setup Apotek';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $slug = 'setup-apotek';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
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