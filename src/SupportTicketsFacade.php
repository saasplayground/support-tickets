<?php

namespace Saasplayground\SupportTickets;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Saasplayground\SupportTickets\Skeleton\SkeletonClass
 */
class SupportTicketsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'support-tickets';
    }
}
