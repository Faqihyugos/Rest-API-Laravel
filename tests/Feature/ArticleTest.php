<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Laravel\Passport\Passport;
use App\Models\User;
use App\Models\Article;

class ArticleTest extends TestCase
{
   use RefreshDatabase, WithFaker;

   public function setUp() :void
   {
       parent::setUp();
       $this->artisan('passport:install');
   }

   public function test_can_create_article()
   {
       Passport::actingAs(
        User::factory()->create(),
        ['api']
       );
       $article = Article::factory()->create();
       $value = [
              'title' => $article->title,
              'content' => $article->content,
              'image' => $article->image,
              'user_id' => $article->user_id,
              'category_id' => $article->category_id
         ];
       $response = $this->post('/api/v1/article', $value);
       $response->assertStatus(201);
   }

   public function test_can_view_all_article()
   {
    Passport::actingAs(
        User::factory()->create(),
        ['api']
       );
    Article::factory()->create();

       $response = $this->get('/api/v1/article');
       $response->assertStatus(200);
   }

   public function test_can_show_detail_article()
   {
       Passport::actingAs(
        User::factory()->create(),
        ['api']
       );
        $article = Article::factory()->create();

        $response = $this->get('/api/v1/article/'.$article->id);
        $response->assertStatus(200);
   }

   public function test_can_update_article()
   {
       Passport::actingAs(
        User::factory()->create(),
        ['api']
       );
        $article = Article::factory()->create();
        $value = [
              'title' => $article->title,
              'content' => $article->content,
              'image' => $article->image,
              'user_id' => $article->user_id,
              'category_id' => $article->category_id
         ];
        $response = $this->put('/api/v1/article/'.$article->id, $value);
        $response->assertStatus(200);
   }

    public function test_can_delete_article()
    {
         Passport::actingAs(
          User::factory()->create(),
          ['api']
         );
          $article = Article::factory()->create();
          $response = $this->delete('/api/v1/article/'.$article->id);
          $response->assertStatus(200);
    }
}
