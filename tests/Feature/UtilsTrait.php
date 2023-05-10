<?php 

namespace Tests\Feature;

use App\Models\User;

trait UtilsTrait 
{
    public function createTokenUser()
    {
        $user  = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
    
        return $token;   
    }

    public function defaultHeaders()
    {
        return [
            'Authorization' => "Bearer {$this->createTokenUser()}",
        ];
    }
}