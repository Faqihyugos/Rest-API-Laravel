<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Laravel\Passport\Passport;
use App\Models\User;
use App\Models\Category;

class CategoryTest extends TestCase
{
   use RefreshDatabase, WithFaker;

    public function setUp() :void
    {
         parent::setUp();
         $this->artisan('passport:install');
    }

    public function test_can_create_category()
    {
        Passport::actingAs(
         User::factory()->create(),
         ['api']
        );
        $category = Category::factory()->create();
        $value = [
               'name' => $category->name,
               'user_id' => $category->user_id,
          ];
          $response = $this->post('/api/v1/category', $value);
        $response->assertStatus(201);
    }
    
    public function test_can_view_all_category()
    {
     Passport::actingAs(
         User::factory()->create(),
         ['api']
        );
     Category::factory()->create();

        $response = $this->get('/api/v1/category');
        $response->assertStatus(200);
    }

    public function test_can_show_detail_category()
    {
        Passport::actingAs(
         User::factory()->create(),
         ['api']
        );
         $category = Category::factory()->create();

        $response = $this->get('/api/v1/category/'.$category->id);
        $response->assertStatus(200);
    }

    public function test_can_update_category()
    {
        Passport::actingAs(
         User::factory()->create(),
         ['api']
        );
         $category = Category::factory()->create();
         $value = [
               'name' => $category->name,
               'user_id' => $category->user_id,
        ];
        $response = $this->put('/api/v1/category/'.$category->id, $value);
        $response->assertStatus(200);
    }

    public function test_can_delete_category()
    {
        Passport::actingAs(
         User::factory()->create(),
         ['api']
        );
         $category = Category::factory()->create();

        $response = $this->delete('/api/v1/category/'.$category->id);
        $response->assertStatus(200);
    }
}
