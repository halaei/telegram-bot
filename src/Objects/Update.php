<?php

namespace Telegram\Bot\Objects;

/**
 * Class Update.
 *
 *
 * @method int                  getUpdateId()               The update's unique identifier. Update identifiers start from a certain positive number and increase sequentially.
 * @method Message              getMessage()                (Optional). New incoming message of any kind - text, photo, sticker, etc.
 * @method Message              getEditedMessage()          (Optional). New version of a message that is known to the bot and was edited.
 * @method InlineQuery          getInlineQuery()            (Optional). New incoming inline query.
 * @method ChosenInlineResult   getChosenInlineResult()     (Optional). A result of an inline query that was chosen by the user and sent to their chat partner.
 * @method CallbackQuery        getCallbackQuery()          (Optional). Incoming callback query.
 *
 * @link https://core.telegram.org/bots/api#update
 */
class Update extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'message'              => Message::class,
            'edited_message'       => Message::class,
            'inline_query'         => InlineQuery::class,
            'chosen_inline_result' => ChosenInlineResult::class,
            'callback_query'       => CallbackQuery::class,
        ];
    }

    /**
     * Determine if the update is of given type
     *
     * @param string         $type
     *
     * @return bool
     */
    public function isType($type)
    {
        if ($this->has(strtolower($type))) {
            return true;
        }
    
        return $this->detectType() === $type;
    }

    /**
     * Detect type based on properties.
     *
     * @return string|null
     */
    public function detectType()
    {
        $types = [
            'message',
            'edited_message',
            'inline_query',
            'chosen_inline_result',
            'callback_query',
        ];

        return $this->keys()
            ->intersect($types)
            ->pop();
    }

    /**
     * Return the related message.
     *
     * @deprecated
     *
     * @return null|Message
     */
    public function getPrivateMessage()
    {
        return $this->getRelatedMessage();
    }

    /**
     * Return the related message.
     *
     * @return null|Message
     */
    public function getRelatedMessage()
    {
        if ($this->has('message')) {
            return $this->getMessage();
        } elseif ($this->has('edited_message')) {
            return $this->getEditedMessage();
        } elseif ($this->has('callback_query')) {
            return $this->getCallbackQuery()->getMessage();
        }
        return null;
    }

    /**
     * Return the related chat if any.
     *
     * @return null|Chat
     */
    public function getChat()
    {
        if ($message = $this->getRelatedMessage()) {
            return $message->getChat();
        }
        return null;
    }

    /**
     * Return the related user that created the update.
     *
     * @return null|User
     */
    public function getFrom()
    {
        if ($this->has('message')) {
            return $this->getMessage()->getFrom();
        } elseif ($this->has('edited_message')) {
            return $this->getEditedMessage()->getFrom();
        } elseif ($this->has('inline_query')) {
            return $this->getInlineQuery()->getFrom();
        } elseif ($this->has('chosen_inline_result')) {
            return $this->getChosenInlineResult()->getFrom();
        } elseif ($this->has('callback_query')) {
            return $this->getCallbackQuery()->getFrom();
        }
        return null;
    }
}
