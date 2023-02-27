<?php

namespace Saasplayground\SupportTickets\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Saasplayground\SupportTickets\Labels\Models\Label;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Saasplayground\SupportTickets\Labels\Models\Label>
 */
class LabelFactory extends Factory
{
    protected $model = Label::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->colorName,
            'usable' => $this->faker->randomElement([true, false]),
        ];
    }
}
