<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\UtilsTrait;
use Tests\TestCase;

class AuthTest extends TestCase
{

    use UtilsTrait;

    public function test_login_validation()
    {
        $response = $this->postJson('/auth/login', []);

        $response->assertStatus(422);
    }

    public function test_login_fail()
    {
        $user = User::factory()->create();
        
        $response = $this->postJson('/auth/login', [
            'email'    => $user->email,
            'password' => 'fakerpassword',
            'device'   => 'test'
        ]);

        $response->assertStatus(422);
    }

    public function test_login()
    {
        $user = User::factory()->create();
        
        $response = $this->postJson('/auth/login', [
            'email'    => $user->email,
            'password' => 'password',
            'device'   => 'test'
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id', 
                'name',
                'email', 
            ],
            'token'
        ]);

        $response->assertStatus(200);
    }

    public function test_logout_unauthenticated()
    {
        
        $response = $this->postJson('/auth/logout');

        $response->assertStatus(401);

    }

    public function test_logout()
    {
        
        $response = $this->withHeaders($this->defaultHeaders())
                         ->postJson('/auth/logout');

        $response->assertStatus(200);

    }
    
    public function test_me_unauthenticated()
    {
        
        $response = $this->getJson('/auth/me');

        $response->assertStatus(401);

    }

    public function test_me()
    {        
        $response = $this->withHeaders($this->defaultHeaders())
                         ->getJson('/auth/me');

        $response->assertStatus(200);

    }
    
}
