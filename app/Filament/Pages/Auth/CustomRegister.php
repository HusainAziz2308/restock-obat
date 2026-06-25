<?php

namespace App\Filament\Pages\Auth;

use App\Models\Pharmacy;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Auth\Pages\Register as BaseRegister;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use \Spatie\Permission\Models\Role;
use \Spatie\Permission\PermissionRegistrar;

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
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function handleRegistration(array $data): Model
    {
        return DB::transaction(function () use ($data) {

            $user = $this->getUserModel()::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'pharmacy_id' => null,
            ]);

            $role = Role::firstOrCreate(['name' => 'Owner', 'guard_name' => 'web']);
            $user->assignRole($role);
            app(PermissionRegistrar::class)->forgetCachedPermissions();

            return $user;
        });
    }

    protected function getRedirectUrl(): string
    {
        return url('/admin/setup-apotek'); 
    }
}
