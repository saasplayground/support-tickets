<?php

namespace Saasplayground\SupportTickets\Tests\Unit;

use Saasplayground\SupportTickets\Labels\Models\Label;
use Saasplayground\SupportTickets\Tests\Models\User;
use Saasplayground\SupportTickets\Tests\TestCase;
use Saasplayground\SupportTickets\Tickets\Models\Ticket;

class LabelTest extends TestCase
{
    public function test_route_key_name_is_slug()
    {
        $this->assertEquals((new Label())->getRouteKeyName(), 'slug');
    }

    public function test_it_returns_correct_slug_from_name()
    {
        $label = Label::factory()->create([
            'name' => $slug = uniqid(),
        ]);

        $this->assertEquals($label->slug, $slug);
    }

    public function test_it_has_many_tickets()
    {
        $label = Label::factory()
                    ->hasAttached(Ticket::factory()->for(User::factory())->count(2), [], 'tickets')
                    ->create();

        $this->assertInstanceOf(Ticket::class, $label->tickets->first());
    }
}
