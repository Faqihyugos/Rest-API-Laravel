<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Models\User;

class UserTest extends TestCase
{
    use WithFaker,RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();
        $this->artisan('passport:install');
    }

    public function test_create_user()
    {
        $value =   [
            'name' => 'Faqihyugos',
            'email' => 'faqi@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ];

        $response = $this->post('/api/v1/register', $value);
        $response->assertStatus(201)->assertJson([
            'meta' => [
                'code' => 201,
                'status' => 'success',
                'message' => 'Register successfully'
            ],
            'data' => [
                'name' => $response->json('data.name'),
                'email' => $response->json('data.email'),
                'updated_at' => $response->json('data.updated_at'),
                'created_at' => $response->json('data.created_at'),
                'id' => $response->json('data.id')]
        ]);
    }

    public function test_login_user()
    {
        $user = User::factory()->create();
        $value = [
            'email' => $user->email,
            'password' => 'password'
        ];
        $response = $this->post('/api/v1/login', $value);
        $response->assertStatus(200)->assertjson([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Login successfully'
            ],
            'data' => [
                'id' => $response->json('data.id'),
                'name' => $response->json('data.name'),
                'email' => $response->json('data.email'),
                'updated_at' => $response->json('data.updated_at'),
                'created_at' => $response->json('data.created_at'),
            ],
            'token' => $response->json('token')
        ]);
    }

    public function test_detail_user()
    {
        Passport::actingAs(
            User::factory()->create(),
            ['api']
        );
        $response = $this->get('/api/v1/user');
        $response->assertStatus(200);
    }
}
