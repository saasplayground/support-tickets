<?php

namespace Saasplayground\SupportTickets\Traits\Eloquent;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Saasplayground\SupportTickets\Labels\Models\Label;
use Saasplayground\SupportTickets\SupportTickets;

trait HasLabelsTrait
{
    /**
     * Boots `HasLabelsTrait` trait.
     *
     * @return void
     */
    public static function bootHasLabelsTrait()
    {
        //
    }

    /**
     * Handles adding and deleting of entity labels.
     *
     * @param  array|int|mixed  $labels
     */
    public function syncLabels($labels)
    {
        $this->removeNonExistingLabels($labels);

        $this->addLabels($labels);
    }

    /**
     * Add labels to the entity.
     *
     * @param  array|int|mixed  $labels
     */
    public function addLabels($labels)
    {
        $this->labels()->syncWithoutDetaching($this->getWorkableLabels($labels));
    }

    /**
     * Removes given labels from entity.
     *
     * @param  array|int|mixed  $labels
     */
    public function detachLabels($labels)
    {
        $this->labels()->detach($this->getWorkableLabels($labels));
    }

    /**
     * Delete labels from entity which are no longer required or available.
     */
    public function removeNonExistingLabels($labels)
    {
        if (! $labels) {
            return;
        }

        if (! $this->labels->count()) {
            return;
        }

        $oldLabels = $this->labels()
            ->whereNotIn('id', $this->getWorkableLabels($labels))
            ->pluck('id')
            ->toArray();

        $this->labels()->detach($oldLabels);
    }

    /**
     * The labels that belong to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function labels()
    {
        return $this->belongsToMany(SupportTickets::getLabelsModel());
    }

    /**
     * Checks and returns an array of service ids.
     *
     * @return array|mixed
     */
    protected function getWorkableLabels($labels)
    {
        if (is_numeric($labels)) {
            return Arr::wrap($labels);
        }

        if ($labels instanceof Label) {
            return Arr::wrap($labels->id);
        }

        if (is_array($labels)) {
            return $labels;
        }

        if ($labels instanceof Collection) {
            return $this->filterLabelsCollection($labels);
        }
    }

    /**
     * Filters out 'labels' which are not an instance of the `Label` model.
     *
     * @return mixed
     */
    protected function filterLabelsCollection($labels)
    {
        return $labels->filter(function ($label) {
            return $label instanceof Label;
        });
    }
}
