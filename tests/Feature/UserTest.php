<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    
    public function test_create_user()
    {
        $value =   [
            'name' => 'Faqih',
            'email' => 'faqihyugos@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ];
        $response = $this->post('/api/v1/register', $value);

        $response->assertStatus(200)->assertJson([
            'success' => true,
            'message' => 'Register successfully',
            'data' => $value
        ]);
    }
}
