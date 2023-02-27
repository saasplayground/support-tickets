<?php

namespace Saasplayground\SupportTickets\Traits\Eloquent;

use Saasplayground\SupportTickets\SupportTickets;

trait InteractsWithTickets
{
    /**
     * Boot the trait.
     *
     * @return void
     */
    public static function bootInteractsWithTickets()
    {
        //
    }

    /**
     * Post a new message on an existing ticket.
     *
     * @param  \Saasplayground\SupportTickets\Tickets\Models\Ticket  $ticket  The ticket model
     * @param  string  $message The message to be posted
     * @param  int|\Illuminate\Database\Eloquent\Model|null  $user The user that will be attached to message
     * @return \Saasplayground\SupportTickets\Tickets\Models\Ticket
     */
    public function postMessageOnTicket($ticket, $message, $user = null)
    {
        $ticket->addMessage($message, $user);

        return $ticket;
    }

    /**
     * Open a new support ticket.
     *
     * @param  array  $data      An array containing title, message, priority, source
     * @param  array  $relations An array of relationships, labels, categories
     * @return \Saasplayground\SupportTickets\Tickets\Models\Ticket
     */
    public function openTicket($data = [], $relations = [])
    {
        $ticket = $this->tickets()->create($data);

        foreach ($relations as $key => $values) {
            if ($key === 'labels') {
                $ticket->addLabels($values);
            }

            if ($key === 'categories') {
                $ticket->addCategories($values);
            }
        }

        return $ticket;
    }

    /**
     * Get the tickets owned by the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(SupportTickets::getTicketsModel());
    }
}
