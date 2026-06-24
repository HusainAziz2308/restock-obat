<?php

namespace App\Filament\Pages\Auth;

use App\Models\Pharmacy;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Auth\Pages\Register as BaseRegister;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use \Spatie\Permission\Models\Role;

class CustomRegister extends BaseRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),

                        TextInput::make('pharmacy_name')
                            ->label('Nama Apotek / Klinik')
                            ->placeholder('Contoh: Apotek Sehat Jaya')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function handleRegistration(array $data): Model
    {
        $planId = request()->query('plan');

        $pharmacy = Pharmacy::create([
            'name' => $data['pharmacy_name'],
            'service_package_id' => $planId,
            'status' => 'active',
        ]);

        $user = $this->getUserModel()::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'pharmacy_id' => $pharmacy->id,
        ]);

        $role = Role::firstOrCreate([
            'name' => 'Owner',
            'guard_name' => 'web'
        ]);

        $user->assignRole($role);
        return $user;
    }
}
