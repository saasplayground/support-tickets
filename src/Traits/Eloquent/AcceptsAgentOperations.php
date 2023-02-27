<?php

namespace Saasplayground\SupportTickets\Traits\Eloquent;

use Saasplayground\SupportTickets\SupportTickets;

trait AcceptsAgentOperations
{
    /**
     * Boot `AcceptsAgentOperations` trait.
     *
     * @return  void
     */
    public static function bootAcceptsAgentOperations()
    {
        //
    }

    /**
     * Posts a message as agent.
     *
     * @param  string  $message The message body
     * @return bool|\Illuminate\Database\Eloquent\Model
     */
    public function postMessageAsAgent($message)
    {
        return $this->addMessage($message, $this->agent);
    }

    /**
     * Assigns an agent to the ticket.
     *
     * @param  int|\Illuminate\Database\Eloquent\Model  $value The user to assign
     * @return bool|\Illuminate\Database\Eloquent\Model
     */
    public function assignAgent($value)
    {
        if (! ($user = $this->resolvedUser($value))) {
            return false;
        }

        $this->agent()->associate($user)->save();

        return $this;
    }

    /**
     * Get the agent that is assigned to entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agent()
    {
        return $this->setConnection(SupportTickets::getUsersDbConnection())
            ->belongsTo(SupportTickets::getUsersModel());
    }
}
