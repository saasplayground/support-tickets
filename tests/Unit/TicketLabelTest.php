<?php

namespace Saasplayground\SupportTickets\Tests\Unit;

use Saasplayground\SupportTickets\Labels\Models\Label;
use Saasplayground\SupportTickets\Tests\Models\User;
use Saasplayground\SupportTickets\Tests\TestCase;
use Saasplayground\SupportTickets\Tickets\Models\Ticket;

class TicketLabelTest extends TestCase
{
    public function test_can_add_labels_via_trait()
    {
        $ticket = Ticket::factory()->for(User::factory())->create();

        $ticket->addLabels(Label::factory()->count(3)->create());

        $this->assertCount(3, $ticket->fresh(['labels'])->labels);

        $this->assertInstanceOf(Label::class, $ticket->labels->first());
    }

    public function test_can_add_labels_via_trait_with_an_array_of_ids()
    {
        $ticket = Ticket::factory()->for(User::factory())->create();

        $ticket->addLabels(Label::factory()->count(3)->create()->pluck('id')->all());

        $this->assertCount(3, $ticket->fresh(['labels'])->labels);

        $this->assertInstanceOf(Label::class, $ticket->labels->first());
    }

    public function test_can_add_single_label_via_trait()
    {
        $ticket = Ticket::factory()->for(User::factory())->create();

        $ticket->addLabels(Label::factory()->create()->id);

        $this->assertCount(1, $ticket->fresh(['labels'])->labels);

        $this->assertInstanceOf(Label::class, $ticket->labels->first());
    }

    public function test_can_detach_labels_via_trait_with_an_array_of_ids()
    {
        $ticket = Ticket::factory()->for(User::factory())->create();

        $ticket->addLabels($labels = Label::factory()->count(3)->create()->pluck('id')->all());

        $ticket->detachLabels($labels);

        $this->assertCount(0, $ticket->fresh(['labels'])->labels);

        $this->assertEmpty($ticket->labels);
    }

    public function test_can_detach_labels_via_trait()
    {
        $ticket = Ticket::factory()->for(User::factory())->create();

        $ticket->addLabels($labels = Label::factory()->count(3)->create());

        $ticket->detachLabels($labels);

        $this->assertCount(0, $ticket->fresh(['labels'])->labels);

        $this->assertEmpty($ticket->labels);
    }

    public function test_can_sync_labels_via_trait()
    {
        $ticket = Ticket::factory()->for(User::factory())->create();

        $ticket->addLabels($labels = Label::factory()->count(3)->create());

        $newLabels = Label::factory()->count(2)->create()->pluck('id')->all();

        $ticket->syncLabels(array_merge(array_slice($labels->pluck('id')->all(), 1), $newLabels));

        $this->assertCount(4, $ticket->fresh(['labels'])->labels);

        $this->assertContains(last($newLabels), $ticket->fresh(['labels'])->labels->pluck('id')->all());
    }
}
