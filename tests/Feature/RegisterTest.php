<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{

    use UtilsTrait;
    
    public function test_register_validation()
    {
        $response = $this->postJson('/auth/register', []);

        $response->assertStatus(422);
    }

    public function test_register()
    {
        $response = $this->postJson('/auth/register', [
                            'name' => 'John Doe',
                            'email' => 'email@email.com',
                            'password' => 'password',
                            'device' => 'test',
                         ]);
        
        $response->assertJsonStructure([
            'data' => [
                'id', 
                'name', 
                'email', 
            ],
            'token'
        ]);
                
        $response->assertStatus(201);
    }
}
