<?php

namespace Saasplayground\SupportTickets\Tests\Unit;

use Saasplayground\SupportTickets\Categories\Models\Category;
use Saasplayground\SupportTickets\Tests\Models\User;
use Saasplayground\SupportTickets\Tests\TestCase;
use Saasplayground\SupportTickets\Tickets\Models\Ticket;

class TicketCategoryTest extends TestCase
{
    public function test_can_add_categories_via_trait()
    {
        $ticket = Ticket::factory()->for(User::factory())->create();

        $ticket->addCategories(Category::factory()->count(3)->create());

        $this->assertCount(3, $ticket->fresh(['categories'])->categories);

        $this->assertInstanceOf(Category::class, $ticket->categories->first());
    }

    public function test_can_add_categories_via_trait_with_an_array_of_ids()
    {
        $ticket = Ticket::factory()->for(User::factory())->create();

        $ticket->addCategories(Category::factory()->count(3)->create()->pluck('id')->all());

        $this->assertCount(3, $ticket->fresh(['categories'])->categories);

        $this->assertInstanceOf(Category::class, $ticket->categories->first());
    }

    public function test_can_add_single_label_via_trait()
    {
        $ticket = Ticket::factory()->for(User::factory())->create();

        $ticket->addCategories(Category::factory()->create()->id);

        $this->assertCount(1, $ticket->fresh(['categories'])->categories);

        $this->assertInstanceOf(Category::class, $ticket->categories->first());
    }

    public function test_can_detach_categories_via_trait_with_an_array_of_ids()
    {
        $ticket = Ticket::factory()->for(User::factory())->create();

        $ticket->addCategories($categories = Category::factory()->count(3)->create()->pluck('id')->all());

        $ticket->detachCategories($categories);

        $this->assertCount(0, $ticket->fresh(['categories'])->categories);

        $this->assertEmpty($ticket->categories);
    }

    public function test_can_detach_categories_via_trait()
    {
        $ticket = Ticket::factory()->for(User::factory())->create();

        $ticket->addCategories($categories = Category::factory()->count(3)->create());

        $ticket->detachCategories($categories);

        $this->assertCount(0, $ticket->fresh(['categories'])->categories);

        $this->assertEmpty($ticket->categories);
    }

    public function test_can_sync_categories_via_trait()
    {
        $ticket = Ticket::factory()->for(User::factory())->create();

        $ticket->addCategories($categories = Category::factory()->count(3)->create());

        $newCategories = Category::factory()->count(2)->create()->pluck('id')->all();

        $ticket->syncCategories(
            array_merge(array_slice($categories->pluck('id')->all(), 1), $newCategories)
        );

        $this->assertCount(4, $ticket->fresh(['categories'])->categories);

        $this->assertContains(
            last($newCategories), $ticket->fresh(['categories'])->categories->pluck('id')->all()
        );
    }
}
