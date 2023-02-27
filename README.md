# API first Support Tickets for Laravel App

[![Latest Version on Packagist](https://img.shields.io/packagist/v/saasplayground/support-tickets.svg?style=flat-square)](https://packagist.org/packages/saasplayground/support-tickets)
[![Total Downloads](https://img.shields.io/packagist/dt/saasplayground/support-tickets.svg?style=flat-square)](https://packagist.org/packages/saasplayground/support-tickets)
![GitHub Actions](https://github.com/saasplayground/support-tickets/actions/workflows/main.yml/badge.svg)

Support Tickets package with API first approach. It provides a simple and easy API to add support tickets to your Laravel app. Supports Laravel 8 and above.

## Installation

You can install the package via composer:

```bash
composer require saasplayground/support-tickets
```

Then publish `config` file:

```
php artisan vendor:publish --tag=support-tickets-config
```

Finally run the migrate command:

```
php artisan migrate
```

## Usage

### User Setup and API

To enable users to open tickets, add `InteractsWithTickets` trait to your `User` model.

```php
use InteractsWithTickets;
```

#### InteractsWithTickets Methods

- `openTicket`: Open a new support ticket.
- `postMessageOnTicket`: Post a new message on an existing ticket.
- `tickets`: Gets tickets owned by user. Query builder methods can be chained on it.

**openTicket Method**: `Ticket`

> Returns an instance of `Ticket` model.

Expects the following parameters:

- `data`: An array containing title, message, priority, source
- `relations`: (Optional) An array of relationships; Support for adding `labels`, `categories`

**postMessageOnTicket Method**: `Ticket`

> Returns an instance of `Ticket` model.

Expects following parameters:

- `ticket`:  The ticket model
- `message`: The message to be posted
- `user`: (Optional) The `id` or `model` of user that will be attached to message

### Tickets Setup and API

By default the `Ticket` model does not need any setup, but if you are extending it, be sure
to update the corresponding value under `models` in config file.

#### Ticket Model Methods

- `syncCategories`: Handles adding and deleting of entity categories.
- `addCategories`: Add categories to the entity.
- `detachCategories`: Removes given categories from entity.
- `categories`: The categories that belong to the model. Query builder methods can be chained on it.
- `syncLabels`: Handles adding and deleting of entity labels.
- `addLabels`: Add labels to the entity.
- `detachLabels`: Removes given labels from entity.
- `labels`: The labels that belong to the model. Query builder methods can be chained on it.
- `addMessage`: Add message to the entity.
- `detachMessages`: Removes a set of messages or all messages from entity.
- `messages`: The messages that belong to the model. Query builder methods can be chained on it.
- `postMessageAsAgent`: Posts a message as agent.
- `assignAgent`: Assigns an agent to the ticket.

**syncCategories**: `void`

Expects the following parameters:

- `categories`: An array of ids, int, or collection (model instances)

**addCategories**: `void`

Expects the following parameters:

- `categories`: An array of ids, int, or collection (model instances)

**detachCategories**: `void`

Expects the following parameters:

- `categories`: An array of ids, int, or collection (model instances)

**categories**: `Collection`

> Returns a collection of or query builder instance of `Category` model.

**syncLabels**: `void`

Expects the following parameters:

- `labels`: An array of ids, int, or collection (model instances)

**addLabels**: `void`

Expects the following parameters:

- `labels`: An array of ids, int, or collection (model instances)

**detachLabels**: `void`

Expects the following parameters:

- `labels`: An array of ids, int, or collection (model instances)

**labels**: `Collection`

> Returns a collection of or query builder instance of `Label` model.

**addMessage**: `false` or `Message`

> Returns false if user cannot be resolved or message cannot be created, else an instance of Message Model

Expects the following parameters:

- `body`: A `string` containing the message
- `user`: (Optional) A user `id`, `Model` or `null` (when null default value is the ticket's user id)

**detachMessages**: `void`

Expects the following parameters:

- `messages`: (Optional) An array of ids, model id, or collection (model instances); 

***Deletes all messages when no value passed.***

**messages**: `Collection`

> Returns a collection of or query builder instance of `Message` model.

**postMessageAsAgent**: `false` or `Message`

> Returns false if user cannot be resolved or message cannot be created, else an instance of Message Model

Expects the following parameters:

- `message`: A `string` containing the message body

**assignAgent**: `false` or `Ticket`

> Returns false if user cannot be resolved, else an instance of `Ticket` model to chain more operations.

Expects the following parameters:

- `value`: `int` or `User` model instance.

#### Configuration

See the published `support-tickets` config file for available options.

**Note**: When modifying the config file, ensure the `users`, `tables` and `models` values are always set.

> Most of the default setup is set to match the basic Laravel app structure, 
hence there is no need to modify the config file heavily.

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email miracuthbert@gmail.com instead of using the issue tracker.

## Credits

-   [Cuthbert Mirambo](https://github.com/miracuthbert)
-   [All Contributors](../../contributors)

## License

The GNU GPLv3. Please see [License File](LICENSE.md) for more information.
