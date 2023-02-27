<?php

namespace Saasplayground\SupportTickets\Labels\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Saasplayground\SupportTickets\Database\Factories\LabelFactory;
use Saasplayground\SupportTickets\SupportTickets;
use Saasplayground\SupportTickets\Tickets\Models\Ticket;
use Saasplayground\SupportTickets\Traits\Eloquent\IsUsable;

class Label extends Model
{
    use HasFactory, Sluggable, SoftDeletes, IsUsable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'usable',
    ];

    /**
     * Generate model's slugs.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['name'],
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
        return SupportTickets::getLabelsTableName();
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return LabelFactory::new();
    }

    /**
     * Get the tickets that belong to the label.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tickets()
    {
        return $this->belongsToMany(Ticket::class, SupportTickets::getTicketsLabelTableName());
    }
}
