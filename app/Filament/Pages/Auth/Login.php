<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login as PagesLogin;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Validation\ValidationException;
use Override;

class Login extends PagesLogin
{
    #[Override]
    public function isUserAllowedToAccessPanel(Authenticatable $user): bool
    {
        if((bool)($user->is_active) === true){
            return true;
        } else {
            throw ValidationException::withMessages([
            'data.email' => __('you are not allowed to access this panel. "INACTIVE!"'),
        ]);
        }
    }
}
