<?php

namespace Saasplayground\SupportTickets\Categories\Models;

use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Saasplayground\SupportTickets\Database\Factories\CategoryFactory;
use Saasplayground\SupportTickets\SupportTickets;
use Saasplayground\SupportTickets\Tickets\Models\Ticket;
use Saasplayground\SupportTickets\Traits\Eloquent\IsUsable;

class Category extends Model
{
    use HasFactory, NodeTrait, Sluggable, SoftDeletes, IsUsable;

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
                'source' => ['name', 'parent.name'],
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
        return SupportTickets::getCategoriesTableName();
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return CategoryFactory::new();
    }

    /**
     * Clone the model into a new, non-existing instance.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function replicate(array $except = null)
    {
        $defaults = [
            $this->getParentIdName(),
            $this->getLftName(),
            $this->getRgtName(),
        ];

        $except = $except ? array_unique(array_merge($except, $defaults)) : $defaults;

        $instance = parent::replicate($except);
        (new SlugService())->slug($instance, true);

        return $instance;
    }

    /**
     * Get the tickets that belong to the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tickets()
    {
        return $this->belongsToMany(Ticket::class, SupportTickets::getTicketsCategoryTableName());
    }
}
