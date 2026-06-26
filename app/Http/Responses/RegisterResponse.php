<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\RegistrationResponse as RegistrationResponseContract;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class RegisterResponse implements RegistrationResponseContract
{
    public function toResponse($request): RedirectResponse | Redirector
    {
        // Paksa Filament melempar ke halaman setup sesaat setelah register sukses!
        return redirect()->to('/admin/setup-apotek');
    }
}