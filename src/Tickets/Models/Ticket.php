<?php

namespace Saasplayground\SupportTickets\Tickets\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Saasplayground\SupportTickets\Database\Factories\TicketFactory;
use Saasplayground\SupportTickets\SupportTickets;
use Saasplayground\SupportTickets\Traits\Eloquent\AcceptsAgentOperations;
use Saasplayground\SupportTickets\Traits\Eloquent\HasCategoriesTrait;
use Saasplayground\SupportTickets\Traits\Eloquent\HasLabelsTrait;
use Saasplayground\SupportTickets\Traits\Eloquent\HasMessagesTrait;
use Saasplayground\SupportTickets\Traits\Eloquent\OwnedByUserTrait;

class Ticket extends Model
{
    use HasFactory,
        Sluggable,
        SoftDeletes,
        OwnedByUserTrait,
        HasCategoriesTrait,
        HasLabelsTrait,
        HasMessagesTrait,
        AcceptsAgentOperations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'message',
        'user_id',
        'priority',
        'source',
        'status',
        'resolved_at',
        'locked_at',
        'archived_at',
        'usable',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
        'locked_at' => 'datetime',
        'archived_at' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($ticket) {
            $ticket->uuid = Str::uuid();
        });
    }

    /**
     * Generate model's slugs.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['title'],
            ],
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return SupportTickets::getTicketsTableName();
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return TicketFactory::new();
    }

    /**
     * The categories that belong to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(
            SupportTickets::getCategoriesModel(),
            SupportTickets::getTicketsCategoryTableName()
        );
    }

    /**
     * The labels that belong to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function labels()
    {
        return $this->belongsToMany(
            SupportTickets::getLabelsModel(),
            SupportTickets::getTicketsLabelTableName()
        );
    }
}
