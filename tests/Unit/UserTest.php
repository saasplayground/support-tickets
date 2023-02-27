<?php

namespace Saasplayground\SupportTickets\Tests\Unit;

use Saasplayground\SupportTickets\Messages\Models\Message;
use Saasplayground\SupportTickets\Tests\Models\User;
use Saasplayground\SupportTickets\Tests\TestCase;
use Saasplayground\SupportTickets\Tickets\Models\Ticket;

class UserTest extends TestCase
{
    public function test_can_create_a_ticket_via_trait()
    {
        /** @var \Saasplayground\SupportTickets\Tickets\Models\Ticket */
        $ticket = Ticket::factory()->make();

        $user = User::factory()->create();

        $user->openTicket($ticket->only('title', 'message', 'priority'));

        $this->assertCount(1, $user->fresh(['tickets'])->tickets);

        $this->assertInstanceOf(Ticket::class, $user->tickets->first());
    }

    public function test_can_post_message_on_ticket_via_trait()
    {
        /** @var \Saasplayground\SupportTickets\Tickets\Models\Ticket */
        $ticket = Ticket::factory()->create();

        $user = User::factory()->create();

        $user->postMessageOnTicket($ticket, 'my test message');

        $this->assertCount(1, $ticket->messages);

        $this->assertInstanceOf(Message::class, $ticket->messages->first());
    }

    public function test_ticket_posted_message_owned_by_user()
    {
        $user = User::factory()->create();

        $ticket = Ticket::factory()->for($user, 'user')->create();

        $user->postMessageOnTicket($ticket, 'my test message');

        $this->assertCount(1, $ticket->messages);

        $this->assertInstanceOf(Message::class, $ticket->messages->first());

        $this->assertEquals($user->id, $ticket->messages->first()->user->id);
    }

    public function test_ticket_message_can_be_posted_by_another_user()
    {
        $user = User::factory()->create();

        $ticket = Ticket::factory()->for($user, 'user')->create();

        $user->postMessageOnTicket($ticket, 'other users message', $anotherUser = User::factory()->create());

        $this->assertCount(1, $ticket->messages);

        $this->assertInstanceOf(Message::class, $ticket->messages->first());

        $this->assertEquals($anotherUser->id, $ticket->messages->first()->user->id);
    }
}
