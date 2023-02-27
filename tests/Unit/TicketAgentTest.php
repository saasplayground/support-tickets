<?php

namespace Saasplayground\SupportTickets\Tests\Unit;

use Saasplayground\SupportTickets\Tests\Models\User;
use Saasplayground\SupportTickets\Tests\TestCase;
use Saasplayground\SupportTickets\Tickets\Models\Ticket;

class TicketAgentTest extends TestCase
{
    public function test_can_be_assigned_an_agent()
    {
        $ticket = Ticket::factory()->for(User::factory())->create();

        $agent = User::factory()->create();

        $ticket->assignAgent($agent);

        $this->assertInstanceOf(User::class, $ticket->fresh()->agent);

        $this->assertEquals($agent->id, $ticket->fresh()->agent->id);
    }

    public function test_can_post_message()
    {
        $ticket = Ticket::factory()->for(User::factory())->create();

        $agent = User::factory()->create();

        $ticket->assignAgent($agent);

        $ticket->postMessageAsAgent('this is the agent');

        $this->assertEquals($agent->id, $ticket->fresh()->agent->id);

        $this->assertInstanceOf(User::class, $ticket->fresh()->messages->first()->user);

        $this->assertEquals($agent->id, $ticket->fresh()->messages->first()->user_id);
    }
}
