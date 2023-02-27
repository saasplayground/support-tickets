<?php

namespace Saasplayground\SupportTickets\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Saasplayground\SupportTickets\Messages\Models\Message;
use Saasplayground\SupportTickets\SupportTickets;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Saasplayground\SupportTickets\Messages\Models\Message>
 */
class MessageFactory extends Factory
{
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $userModel = SupportTickets::getUsersModel();
        $ticketModel = SupportTickets::getTicketsModel();

        return [
            'body' => $this->faker->paragraph,
            'user_id' => $userModel::factory(),
            'ticket_id' => $ticketModel::factory(),
        ];
    }
}
