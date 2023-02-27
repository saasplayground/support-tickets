<?php

namespace Saasplayground\SupportTickets\Tests\Unit;

use Saasplayground\SupportTickets\Messages\Models\Message;
use Saasplayground\SupportTickets\Tests\Models\User;
use Saasplayground\SupportTickets\Tests\TestCase;
use Saasplayground\SupportTickets\Tickets\Models\Ticket;

class TicketMessagesTest extends TestCase
{
    public function test_can_add_messages_via_trait()
    {
        $ticket = Ticket::factory()->for(User::factory())->create();

        $ticket->addMessage('a new message');

        $this->assertCount(1, $ticket->fresh(['messages'])->messages);

        $this->assertInstanceOf(Message::class, $ticket->messages->first());
    }

    public function test_can_detach_messages_via_trait_with_an_array_of_ids()
    {
        $ticket = Ticket::factory()->for(User::factory())
            ->has(Message::factory()->count(3), 'messages')
            ->create();

        $this->assertCount(3, $ticket->fresh(['messages'])->messages);

        $messages = $ticket->messages->pluck('id')->all();

        $ticket->detachMessages($messages);

        $this->assertCount(0, $ticket->fresh(['messages'])->messages);

        $this->assertEmpty($ticket->fresh(['messages'])->messages);
    }

    public function test_can_detach_messages_via_trait()
    {
        $ticket = Ticket::factory()->for(User::factory())
            ->has(Message::factory()->count(3), 'messages')
            ->create();

        $this->assertCount(3, $ticket->fresh(['messages'])->messages);

        $messages = $ticket->messages;

        $ticket->detachMessages($messages);

        $this->assertCount(0, $ticket->fresh(['messages'])->messages);

        $this->assertEmpty($ticket->fresh(['messages'])->messages);
    }

    public function test_can_delete_all_messages_via_trait()
    {
        $ticket = Ticket::factory()->for(User::factory())
            ->has(Message::factory()->count(3), 'messages')
            ->create();

        $this->assertCount(3, $ticket->fresh(['messages'])->messages);

        $ticket->detachMessages();

        $this->assertCount(0, $ticket->fresh(['messages'])->messages);

        $this->assertEmpty($ticket->fresh(['messages'])->messages);
    }
}
