<?php

namespace Saasplayground\SupportTickets\Tests\Unit;

use Saasplayground\SupportTickets\Categories\Models\Category;
use Saasplayground\SupportTickets\Tests\Models\User;
use Saasplayground\SupportTickets\Tests\TestCase;
use Saasplayground\SupportTickets\Tickets\Models\Ticket;

class CategoryTest extends TestCase
{
    public function test_route_key_name_is_slug()
    {
        $this->assertEquals((new Category())->getRouteKeyName(), 'slug');
    }

    public function test_it_returns_correct_slug_from_name()
    {
        $category = Category::factory()->create([
            'name' => $slug = uniqid(),
        ]);

        $this->assertEquals($category->slug, $slug);
    }

    public function test_it_has_many_tickets()
    {
        $category = Category::factory()
                    ->hasAttached(Ticket::factory()->for(User::factory())->count(2), [], 'tickets')
                    ->create();

        $this->assertInstanceOf(Ticket::class, $category->tickets->first());
    }
}
