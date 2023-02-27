<?php

namespace Saasplayground\SupportTickets\Traits\Eloquent;

use Saasplayground\SupportTickets\SupportTickets;

trait OwnedByUserTrait
{
    /**
     * Boot the trait.
     */
    public static function bootsOwnedByUserTrait()
    {
        //
    }

    /**
     * Get the user that owns the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->setConnection(SupportTickets::getUsersDbConnection())
            ->belongsTo(SupportTickets::getUsersModel());
    }
}
