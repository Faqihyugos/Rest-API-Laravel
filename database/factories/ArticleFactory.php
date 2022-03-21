<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title(),
            'content' => $this->faker->text(),
            'image' => $this->faker->image(
                storage_path('app/public/assets/img_article'),
                $this->faker->numberBetween(100, 500),
                $this->faker->numberBetween(100, 500),
                null,
                false
            ),
            'user_id' => function () {
                return User::factory()->create()->first('id');
            },
            'category_id' => function () {
                return Category::factory()->create()->first('id');
            }
        ];
    }
}
