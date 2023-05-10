<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use UtilsTrait;

    public function test_get_all_users_unauthenticated()
    {
        $response = $this->getJson('/admin/users');

        $response->assertStatus(401);
    }

    public function test_get_all_users()
    {
        $response = $this->withHeaders($this->defaultHeaders())
            ->getJson('/admin/users');

        $response->assertStatus(200);
    }

    public function test_count_users()
    {
        User::factory()->count(9)->create();

        $response = $this->withHeaders($this->defaultHeaders())
            ->getJson('/admin/users');

        $response->assertJsonCount(10, 'data');
        $response->assertStatus(200);
    }

    public function test_get_user_fail()
    {
        $response = $this->withHeaders($this->defaultHeaders())
            ->getJson('/admin/users/fake_id');

        $response->assertStatus(404);
    }

    public function test_get_user()
    {
        $user = User::factory()->create();

        $response = $this->withHeaders($this->defaultHeaders())
            ->getJson("/admin/users/{$user->id}");

        $response->assertStatus(200);
    }

    public function test_store_user_validation()
    {
        $response = $this->withHeaders($this->defaultHeaders())
            ->postJson('/admin/users', []);

        $response->assertStatus(422);
    }

    public function test_store_user()
    {
        $response = $this->withHeaders($this->defaultHeaders())
            ->postJson('/admin/users', [
                'name'      => 'John Doe',
                'email'     => 'email@email.com',
                'password'  => 'password'
            ]);

        $response->assertStatus(201);
    }

    public function test_update_user_not_found()
    {
        $response = $this->withHeaders($this->defaultHeaders())
            ->putJson('/admin/users/fake_id', [
                'name'  => 'John Doe',
                'email' => 'email@email.com',
            ]);

        $response->assertStatus(404);
    }

    public function test_update_user_validation()
    {
        $user = User::factory()->create();

        $response = $this->withHeaders($this->defaultHeaders())
            ->putJson("/admin/users/{$user->id}", []);

        $response->assertStatus(422);
    }

    public function test_update_user()
    {
        $user = User::factory()->create();

        $response = $this->withHeaders($this->defaultHeaders())
            ->putJson("/admin/users/{$user->id}", [
                'name'  => 'John Doe Updated',
                'email' => 'email@email.com',
            ]);

        $response->assertStatus(200);
    }

    public function test_delete_user_not_found()
    {
        $response = $this->withHeaders($this->defaultHeaders())
            ->deleteJson('/admin/users/fake_id');

        $response->assertStatus(404);
    }

    public function test_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->withHeaders($this->defaultHeaders())
            ->deleteJson("/admin/users/{$user->id}");

        $response->assertStatus(200);
    }
}
