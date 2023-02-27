<?php

namespace Saasplayground\SupportTickets\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Saasplayground\SupportTickets\Categories\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Saasplayground\SupportTickets\Categories\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->colorName(),
            'usable' => $this->faker->randomElement([true, false]),
        ];
    }
}
