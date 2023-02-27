<?php

namespace Saasplayground\SupportTickets\Traits\Eloquent;

use Illuminate\Database\Eloquent\Builder;

trait IsUsable
{
    /**
     * Scope query to only include 'active' models.
     *
     * @param  string  $column
     */
    public function scopeActive(Builder $builder, $column = 'usable')
    {
        $builder->where($column, true);
    }

    /**
     * Scope query to include only live models.
     *
     * @return Builder
     */
    public function scopeLive(Builder $builder)
    {
        return $builder->where('live', true);
    }
}
