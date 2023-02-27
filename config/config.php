<?php

/*
 * You can place your custom package configuration in here.
 */
return [

    /**
     * Users Settings.
     *
     * Set values related to the User model.
     */
    'users' => [

        'model' => \App\Models\User::class,

        /**
         * Set the table to be used when querying for users.
         *
         * Note: Do not change this value unless you are using a
         * different table name.
         */
        'table' => 'users',

        /**
         * Set the db connection to be used for querying the users table
         * relationship.
         *
         * Note: Do not set the value to null or package will breakdown.
         */
        'db_connection' => env('DB_CONNECTION'),
    ],

    /**
     * Tables Settings.
     *
     * The names of the tables to be used in the packages migrations.
     */
    'tables' => [
        'labels' => 'spptcks_labels',
        'categories' => 'spptcks_categories',
        'tickets' => 'spptcks_tickets',
        'tickets_label' => 'spptcks_label_ticket',
        'tickets_category' => 'spptcks_category_ticket',
        'messages' => 'spptcks_messages',
    ],

    /**
     * Models Settings.
     *
     * The models that will be used to drive the packages different
     * functions.
     */
    'models' => [
        'users' => \App\Models\User::class,
        'tickets' => \Saasplayground\SupportTickets\Tickets\Models\Ticket::class,
        'messages' => \Saasplayground\SupportTickets\Messages\Models\Message::class,
        'categories' => \Saasplayground\SupportTickets\Categories\Models\Category::class,
        'labels' => \Saasplayground\SupportTickets\Labels\Models\Label::class,
    ],

    /**
     * Routes Setting.
     *
     * Set the settings for the packages routes here.
     */
    'routes' => [

        /**
         * The route prefix for the packages routes.
         */
        'prefix' => '/support',

        /**
         * The prefix for route names for the packages routes.
         */
        'as' => 'support.',

        /**
         * The global middleware for the package.
         */
        'middleware' => [
            'web',
        ],

        /**
         * Auth Middleware
         *
         * The Auth middleware for the package routes that perform form requests.
         */
        'auth_middleware' => [
            'auth',
        ],
    ],

    /**
     * Model's Resource Map.
     *
     * Register models API Resource that will be used to output the related data.
     */
    'resources' => [
        // \App\Models\User::class => \Saasplayground\SupportTickets\Http\Users\Resources\UserResource::class,
        // \Saasplayground\SupportTickets\Labels\Models\Label::class => \Saasplayground\SupportTickets\Http\Labels\Resources\LabelResource::class,
        // \Saasplayground\SupportTickets\Tickets\Models\Ticket::class => \Saasplayground\SupportTickets\Http\Tickets\Resources\TicketResource::class,
        // \Saasplayground\SupportTickets\Messages\Models\Message::class => \Saasplayground\SupportTickets\Http\Messages\Resources\MessageResource::class,
        // \Saasplayground\SupportTickets\Categories\Models\Category::class => \Saasplayground\SupportTickets\Http\Categories\Resources\CategoryResource::class,
    ],

    /**
     * Model's Policies Map.
     *
     * Register policies for models that control who can post, comment, or own forums.
     *
     * We got you started with the 'CommentPolicy' to handle reply, update and destroy.
     */
    'policies' => [
        \Saasplayground\SupportTickets\Labels\Models\Label::class => \Saasplayground\SupportTickets\Policies\Labels\Policies\LabelPolicy::class,
        \Saasplayground\SupportTickets\Categories\Models\Category::class => \Lunacms\Categories\Policies\Categories\Policies\CategoryPolicy::class,
        \Saasplayground\SupportTickets\Tickets\Models\Ticket::class => \Saasplayground\SupportTickets\Policies\Tickets\Policies\TicketPolicy::class,
        \Saasplayground\SupportTickets\Messages\Models\Message::class => \Saasplayground\SupportTickets\Policies\Messages\Policies\MessagePolicy::class,
    ],
];
