<?php

namespace Saasplayground\SupportTickets\Traits\Eloquent;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Saasplayground\SupportTickets\Categories\Models\Category;
use Saasplayground\SupportTickets\SupportTickets;

trait HasCategoriesTrait
{
    /**
     * Boots `HasCategoriesTrait` trait.
     *
     * @return void
     */
    public static function bootHasCategoriesTrait()
    {
        //
    }

    /**
     * Handles adding and deleting of entity categories.
     *
     * @param  array|int|mixed  $categories
     */
    public function syncCategories($categories)
    {
        $this->removeNonExistingCategories($categories);

        $this->addCategories($categories);
    }

    /**
     * Add categories to the entity.
     *
     * @param  array|int|mixed  $categories
     */
    public function addCategories($categories)
    {
        $this->categories()->syncWithoutDetaching($this->getWorkableCategories($categories));
    }

    /**
     * Removes given categories from entity.
     *
     * @param  array|int|mixed  $categories
     */
    public function detachCategories($categories)
    {
        $this->categories()->detach($this->getWorkableCategories($categories));
    }

    /**
     * Delete categories from entity which are no longer required or available.
     */
    public function removeNonExistingCategories($categories)
    {
        if (! $categories) {
            return;
        }

        if (! $this->categories->count()) {
            return;
        }

        $oldCategories = $this->categories()
            ->whereNotIn('id', $this->getWorkableCategories($categories))
            ->pluck('id')
            ->toArray();

        $this->categories()->detach($oldCategories);
    }

    /**
     * The categories that belong to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(SupportTickets::getCategoriesModel());
    }

    /**
     * Checks and returns an array of service ids.
     *
     * @return array|mixed
     */
    protected function getWorkableCategories($categories)
    {
        if (is_numeric($categories)) {
            return Arr::wrap($categories);
        }

        if ($categories instanceof Category) {
            return Arr::wrap($categories->id);
        }

        if (is_array($categories)) {
            return $categories;
        }

        if ($categories instanceof Collection) {
            return $this->filterCategoriesCollection($categories);
        }
    }

    /**
     * Filters out 'categories' which are not an instance of the `Category` model.
     *
     * @return mixed
     */
    protected function filterCategoriesCollection($categories)
    {
        return $categories->filter(function ($category) {
            return $category instanceof Category;
        });
    }
}
