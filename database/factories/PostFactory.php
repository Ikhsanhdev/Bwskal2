<?php

namespace Database\Factories;

use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text();
        $slug = slug_with_random_number($title);

        return [
            'user_id'     => User::factory(),
            'category_id' => PostCategory::factory(),
            'title'       => $title,
            'slug'        => $slug,
            'content'     => $this->faker->realText(600)
        ];
    }
}
