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
            'title' => $this->faker->sentence(),
            'user_id' => $this->faker->numberBetween(1, User::count()),
            'category_id' => $this->faker->numberBetween(1, Category::count()),
            'content' => $this->faker->paragraphs(3, true),
            'image' => $this->faker->sentence()
        ];
    }
}
