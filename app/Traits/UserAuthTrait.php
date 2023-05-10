<?php 

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait UserAuthTrait 
{
    private function getUser(): User
    {
        return Auth::user();
    }

    private function isLogged()
    {
        return Auth::check();
    }
}