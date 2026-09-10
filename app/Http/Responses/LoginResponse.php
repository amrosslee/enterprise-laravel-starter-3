<?php

namespace App\Http\Responses;

use App\Enums\UserRoles;
use Filament\Auth\Http\Responses\LoginResponse as ResponsesLoginResponse;
use Filament\Facades\Filament;
use Filament\Pages\Dashboard;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class LoginResponse extends ResponsesLoginResponse
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        $authUserIsAdmin = auth()->user()?->hasRole(UserRoles::Admin->value) ?? false;
        if ($authUserIsAdmin ) {
            return redirect()->to(Filament::getPanel('admin')->getUrl());
        } else {
            return redirect()->to(Filament::getPanel('company')->getUrl());
        }

        return parent::toResponse($request);
    }
}
