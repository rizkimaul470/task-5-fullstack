<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Faker\Generator as Faker;
use App\Models\Articles;

class ArticlesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text('20'),
            'content' => $this->faker->text('100'),
            'image' => $this->faker->url(),
            'user_id' => $this->faker->numberBetween($min = 4, $max = 5),
            'category_id' => $this->faker->numberBetween($min = 3, $max = 5),
        ];
    }
}
