<?php

namespace Saasplayground\SupportTickets\Traits\Eloquent;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Saasplayground\SupportTickets\Messages\Models\Message;
use Saasplayground\SupportTickets\SupportTickets;

trait HasMessagesTrait
{
    /**
     * Boots `HasMessagesTrait` trait.
     *
     * @return void
     */
    public static function bootHasMessagesTrait()
    {
        //
    }

    /**
     * Resolve user from value and return id.
     *
     * @param  int|\Illuminate\Database\Eloquent\Model|mixed  $value   A user value
     * @param  int  $default The fallback user id
     * @return int
     */
    protected function resolvedUser($value, $default = null)
    {
        $class = new (SupportTickets::getUsersModel());

        if ($value instanceof $class) {
            return $value->id;
        } elseif (is_numeric($value)) {
            $user = $class::find($value);

            return ! empty($user) ? $user->id : $default;
        }

        return $default;
    }

    /**
     * Add message to the entity.
     *
     * @param  string  $body
     * @param  id|\Illuminate\Database\Eloquent\Model|null  $user
     * @return bool|mixed
     */
    public function addMessage($body, $user = null)
    {
        $class = SupportTickets::getMessagesModel();

        if (! ($userId = $this->resolvedUser($user, $this->user_id))) {
            return false;
        }

        /** @var \Saasplayground\SupportTickets\Messages\Models\Message */
        $message = new $class;

        $message->fill([
            'body' => $body,
            'user_id' => $userId,
        ]);

        return $this->messages()->save($message);
    }

    /**
     * Removes a set of messages or all messages from entity.
     *
     * @param  array|int  $messages
     */
    public function detachMessages($messages = [])
    {
        if (is_array($messages) && count($messages) === 0) {
            $this->messages()->delete();
        } else {
            $this->messages()->delete($this->getWorkableMessages($messages));
        }
    }

    /**
     * The messages that belong to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(SupportTickets::getMessagesModel());
    }

    /**
     * Checks and returns an array of service ids.
     *
     * @return  array|mixed
     */
    protected function getWorkableMessages($messages)
    {
        if (is_int($messages)) {
            return Arr::wrap($messages);
        }

        if ($messages instanceof Message) {
            return Arr::wrap($messages->id);
        }

        if (is_array($messages)) {
            return $messages;
        }

        if ($messages instanceof Collection) {
            return $this->filterMessagesCollection($messages)->pluck('id')->all();
        }
    }

    /**
     * Filters out 'messages' which are not an instance of the `Message` model.
     *
     * @return  mixed
     */
    protected function filterMessagesCollection($messages)
    {
        return $messages->filter(function ($label) {
            return $label instanceof Message;
        });
    }
}
