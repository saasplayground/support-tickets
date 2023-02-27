<?php

namespace Saasplayground\SupportTickets\Tests\Unit;

use Illuminate\Support\Arr;
use Saasplayground\SupportTickets\Categories\Models\Category;
use Saasplayground\SupportTickets\Labels\Models\Label;
use Saasplayground\SupportTickets\Messages\Models\Message;
use Saasplayground\SupportTickets\Tests\Models\User;
use Saasplayground\SupportTickets\Tests\TestCase;
use Saasplayground\SupportTickets\Tickets\Models\Ticket;

class TicketTest extends TestCase
{
    public function test_it_has_route_key_name()
    {
        $this->assertEquals((new Ticket())->getRouteKeyName(), 'slug');
    }

    public function test_it_returns_correct_slug_from_title()
    {
        $ticket = Ticket::factory()->for(User::factory())->create([
            'title' => $slug = uniqid(),
            'slug' => null,
        ]);

        $this->assertEquals($ticket->slug, $slug);
    }

    public function test_a_new_ticket_has_open_status_by_default()
    {
        $ticket = Ticket::factory()->for(User::factory())->make()->toArray();
        $ticket = Ticket::create(Arr::except($ticket, 'status'));

        $this->assertEquals($ticket->status, 'open');
    }

    public function test_its_owned_by_a_user()
    {
        $ticket = Ticket::factory()->for(User::factory())->create();

        $this->assertInstanceOf(User::class, $ticket->user);
    }

    public function test_has_many_labels()
    {
        $ticket = Ticket::factory()->for(User::factory())
                    ->hasAttached(
                        Label::factory()->count(3), [], 'labels'
                    )->create();

        $this->assertInstanceOf(Label::class, $ticket->labels->first());
    }

    public function test_has_many_categories()
    {
        $ticket = Ticket::factory()->for(User::factory())
                    ->hasAttached(
                        Category::factory()->count(3), [], 'categories'
                    )->create();

        $this->assertInstanceOf(Category::class, $ticket->categories->first());
    }

    public function test_has_many_messages()
    {
        $ticket = Ticket::factory()->for(User::factory())
                    ->has(
                        Message::factory()->count(3), 'messages'
                    )->create();

        $this->assertCount(3, $ticket->fresh('messages')->messages);

        $this->assertInstanceOf(Message::class, $ticket->messages->first());
    }
}
