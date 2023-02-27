<?php

namespace Saasplayground\SupportTickets\Messages\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Saasplayground\SupportTickets\Database\Factories\MessageFactory;
use Saasplayground\SupportTickets\SupportTickets;
use Saasplayground\SupportTickets\Tickets\Models\Ticket;
use Saasplayground\SupportTickets\Traits\Eloquent\OwnedByUserTrait;

class Message extends Model
{
    use HasFactory, NodeTrait, SoftDeletes, OwnedByUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body',
        'user_id',
        'ticket_id',
    ];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return SupportTickets::getMessagesTableName();
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return MessageFactory::new();
    }

    /**
     * Get the ticket that owns the message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
