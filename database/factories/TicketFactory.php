<?php

namespace Saasplayground\SupportTickets\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Saasplayground\SupportTickets\SupportTickets;
use Saasplayground\SupportTickets\Tickets\Models\Ticket;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Saasplayground\SupportTickets\Tickets\Models\Ticket>
 */
class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $userModel = SupportTickets::getUsersModel();
        $resolved = $this->faker->randomElement([null, now()]);
        $locked = $this->faker->randomElement([null, now()]);

        return [
            'title' => $this->faker->words(3, true),
            'slug' => $this->faker->unique()->slug,
            'message' => $this->faker->paragraph,
            'user_id' => $userModel::factory(),
            'priority' => $this->faker->randomElement(SupportTickets::getPriorityMap()),
            'source' => $this->faker->randomElement(SupportTickets::getSourcesMap()),
            'status' => $resolved ? 'closed' : $this->faker->randomElement(SupportTickets::getStatusMap()),
            'resolved_at' => $resolved,
            'locked_at' => $locked,
        ];
    }
}
