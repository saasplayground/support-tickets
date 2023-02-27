<?php

namespace Saasplayground\SupportTickets;

use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\DB;
use Saasplayground\SupportTickets\Categories\Models\Category;
use Saasplayground\SupportTickets\Labels\Models\Label;
use Saasplayground\SupportTickets\Messages\Models\Message;
use Saasplayground\SupportTickets\Tickets\Models\Ticket;

class SupportTickets
{
    const STATUS_OPEN = 'open';

    const STATUS_RECENT = 'recent';

    const STATUS_CLOSED = 'closed';

    const STATUS_RESOLVED = 'resolved';

    public static $priorityMap = ['urgent', 'high', 'medium', 'low'];

    public static $sourcesMap = [
        'web', 'email', 'phone', 'chat', 'facebook', 'twitter', 'whatsapp',
        'portal', 'bots', 'external email', 'feedback widget',
    ];

    public static $statusMap = [
        self::STATUS_OPEN,
        self::STATUS_CLOSED,
        self::STATUS_RESOLVED,
    ];

    /**
     * Get an array of ticket priority levels.
     *
     * @return array
     */
    public static function getPriorityMap()
    {
        return static::$priorityMap;
    }

    /**
     * Get an array of ticket creation sources.
     *
     * @return array
     */
    public static function getSourcesMap()
    {
        return static::$sourcesMap;
    }

    /**
     * Get an array of available ticket statuses.
     *
     * @return array
     */
    public static function getStatusMap()
    {
        return static::$statusMap;
    }

    /**
     * Get the defined users model.
     *
     * @return string
     */
    public static function defaultStatus()
    {
        return static::STATUS_OPEN;
    }

    /**
     * Get the defined users model.
     *
     * @return string
     */
    public static function getUsersModel()
    {
        return config('support-tickets.users.model', \App\Models\User::class);
    }

    /**
     * Get the defined users table name.
     *
     * @return string
     */
    public static function getUsersTableName()
    {
        return config('support-tickets.users.table', 'users');
    }

    /**
     * Get the defined users table database connection.
     *
     * @return string
     */
    public static function getUsersDbConnection()
    {
        return config('support-tickets.users.db_connection', env('DB_CONNECTION'));
    }

    /**
     * Get the expression used to define users table connection.
     *
     * @return string
     */
    public static function getUsersConnectionExpression()
    {
        $database = DB::connection(SupportTickets::getUsersDbConnection())
                ->getDatabaseName();

        $usersTable = SupportTickets::getUsersTableName();

        return new Expression($database.'.'.$usersTable);
    }

    /**
     * Get labels table name.
     *
     * @return string
     */
    public static function getLabelsTableName()
    {
        return config('support-tickets.tables.labels', 'spptcks_labels');
    }

    /**
     * Get categories table name.
     *
     * @return string
     */
    public static function getCategoriesTableName()
    {
        return config('support-tickets.tables.categories', 'spptcks_categories');
    }

    /**
     * Get tickets table name.
     *
     * @return string
     */
    public static function getTicketsTableName()
    {
        return config('support-tickets.tables.tickets', 'spptcks_tickets');
    }

    /**
     * Get the name of the pivot table for the tickets label relationship.
     *
     * @return string
     */
    public static function getTicketsLabelTableName()
    {
        return config('support-tickets.tables.tickets_label', 'spptcks_label_ticket');
    }

    /**
     * Get the name of the pivot table for the tickets category relationship.
     *
     * @return string
     */
    public static function getTicketsCategoryTableName()
    {
        return config('support-tickets.tables.tickets_category', 'spptcks_category_ticket');
    }

    /**
     * Get messages table name.
     *
     * @return string
     */
    public static function getMessagesTableName()
    {
        return config('support-tickets.tables.messages', 'spptcks_messages');
    }

    /**
     * Get the tickets model class.
     *
     * @return string
     */
    public static function getTicketsModel()
    {
        return config('support-tickets.models.tickets', Ticket::class);
    }

    /**
     * Get the messages model class.
     *
     * @return string
     */
    public static function getMessagesModel()
    {
        return config('support-tickets.models.messages', Message::class);
    }

    /**
     * Get the categories model class.
     *
     * @return string
     */
    public static function getCategoriesModel()
    {
        return config('support-tickets.models.categories', Category::class);
    }

    /**
     * Get the label model class.
     *
     * @return string
     */
    public static function getLabelsModel()
    {
        return config('support-tickets.models.labels', Label::class);
    }
}
