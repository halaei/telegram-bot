<?php

namespace Telegram\Bot\Objects;

/**
 * Class Message.
 *
 *
 * @method int                getMessageId()              Unique message identifier.
 * @method User               getFrom()                   (Optional). Sender, can be empty for messages sent to channels.
 * @method int                getDate()                   Date the message was sent in Unix time.
 * @method Chat               getChat()                   Conversation the message belongs to.
 * @method User               getForwardFrom()            (Optional). For forwarded messages, sender of the original message.
 * @method Chat               getForwardFromChat()        (Optional). For messages forwarded from a channel, information about the original channel.
 * @method int                getForwardFromMessageId()   (Optional). For forwarded channel posts, identifier of the original message in the channel.
 * @method string             getForwardSignature()       (Optional). For messages forwarded from channels, signature of the post author if present.
 * @method string             getForwardSenderName()      (Optional). Sender's name for messages forwarded from users who disallow adding a link to their account in forwarded messages
 * @method int                getForwardDate()            (Optional). For forwarded messages, date the original message was sent in Unix time.
 * @method Message            getReplyToMessage()         (Optional). For replies, the original message. Note that the Message object in this field will not contain further reply_to_message fields even if it itself is a reply.
 * @method string             getAuthorSignature()        (Optional). Signature of the post author for messages in channels.
 * @method MessageEntity[]    getEntities()               (Optional). For text messages, special entities like usernames, URLs, bot commands, etc. that appear in the text.
 * @method MessageEntity[]    getCaptionEntities()        (Optional). For messages with a caption, special entities like usernames, URLs, bot commands, etc. that appear in the caption.
 * @method Audio              getAudio()                  (Optional). Message is an audio file, information about the file.
 * @method Document           getDocument()               (Optional). Message is a general file, information about the file.
 * @method Animation          getAnimation()              (Optional). Message is an animation, information about the animation. For backward compatibility, when this field is set, the document field will also be set.
 * @method Game               getGame()                   (Optional). Message is a game, information about the game.
 * @method PhotoSize[]        getPhoto()                  (Optional). Message is a photo, available sizes of the photo.
 * @method Sticker            getSticker()                (Optional). Message is a sticker, information about the sticker.
 * @method Video              getVideo()                  (Optional). Message is a video, information about the video.
 * @method Voice              getVoice()                  (Optional). Message is a voice message, information about the file.
 * @method VideoNote          getVideoNote()              (Optional). Message is a video note, information about the video message.
 * @method User[]             getNewChatMembers()         (Optional). New members that were added to the group or supergroup and information about them (the bot itself may be one of these members).
 * @method Contact            getContact()                (Optional). Message is a shared contact, information about the contact.
 * @method Location           getLocation()               (Optional). Message is a shared location, information about the location.
 * @method Venue              getVenue()                  (Optional). Message is a venue, information about the venue.
 * @method Poll               getPoll()                   (Optional). Message is a native poll, information about the poll.
 * @method User               getNewChatMember()          (deprecated. Replaced with new_chat_members)(Optional). A new member was added to the group, information about them (this member may be the bot itself).
 * @method User               getLeftChatMember()         (Optional). A member was removed from the group, information about them (this member may be the bot itself).
 * @method string             getNewChatTitle()           (Optional). A chat title was changed to this value.
 * @method PhotoSize[]        getNewChatPhoto()           (Optional). A chat photo was change to this value.
 * @method bool               getDeleteChatPhoto()        (Optional). Service message: the chat photo was deleted.
 * @method bool               getGroupChatCreated()       (Optional). Service message: the group has been created.
 * @method bool               getSupergroupChatCreated()  (Optional). Service message: the super group has been created.
 * @method bool               getChannelChatCreated()     (Optional). Service message: the channel has been created.
 * @method int                getMigrateToChatId()        (Optional). The group has been migrated to a supergroup with the specified identifier, not exceeding 1e13 by absolute value.
 * @method int                getMigrateFromChatId()      (Optional). The supergroup has been migrated from a group with the specified identifier, not exceeding 1e13 by absolute value.
 * @method Message            getPinnedMessage()          (Optional). Specified message was pinned. Note that the Message object in this field will not contain further reply_to_message fields even if it is itself a reply.
 * @method Invoice            getInvoice()                (Optional). Message is an invoice for a payment, information about the invoice.
 * @method SuccessfulPayment getSuccessfulPayment()     (Optional). Message is a service message about a successful payment, information about the payment.
 */
class Message extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'from'               => User::class,
            'chat'               => Chat::class,
            'forward_from'       => User::class,
            'forward_from_chat'  => Chat::class,
            'reply_to_message'   => self::class,
            'entities'           => MessageEntity::class,
            'caption_entities'   => MessageEntity::class,
            'audio'              => Audio::class,
            'document'           => Document::class,
            'animation'          => Animation::class,
            'game'               => Game::class,
            'photo'              => PhotoSize::class,
            'sticker'            => Sticker::class,
            'video'              => Video::class,
            'voice'              => Voice::class,
            'video_note'         => VideoNote::class,
            'contact'            => Contact::class,
            'location'           => Location::class,
            'venue'              => Venue::class,
            'poll'               => Poll::class,
            'new_chat_members'   => User::class,
            'new_chat_member'    => User::class,
            'left_chat_member'   => User::class,
            'new_chat_photo'     => PhotoSize::class,
            'pinned_message'     => Message::class,
            'invoice'            => Invoice::class,
            'successful_payment' => SuccessfulPayment::class,
        ];
    }

    /**
     * (Optional). For text messages, the actual UTF-8 text of the message.
     *
     * @return string
     */
    public function getText()
    {
        return $this->get('text');
    }

    /**
     * (Optional). Date the message was last edited in Unix time.
     *
     * @return int
     */
    public function getEditDate()
    {
        return (int) $this->get('edit_date');
    }

    /**
     * (Optional). Caption for the document, photo or video contact.
     *
     * @return string
     */
    public function getCaption()
    {
        return $this->get('caption');
    }

    /**
     * Determine if the message is of given type.
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
     * Get the text of a given message entity.
     *
     * @param MessageEntity $entity
     * @return string
     */
    public function getEntityText(MessageEntity $entity)
    {
        return $this->substr($this->getText(), $entity->getOffset(), $entity->getLength());
    }

    /**
     * Get the text of a given caption entity.
     *
     * @param MessageEntity $entity
     * @return string
     */
    public function getCaptionEntityText(MessageEntity $entity)
    {
        return $this->substr($this->getCaption(), $entity->getOffset(), $entity->getLength());
    }

    /**
     * Substring based on UTF-16 code units.
     *
     * @param string $text
     * @param string $start
     * @param int $length
     *
     * @return string
     */
    protected function substr($text, $start, $length)
    {
        $array = preg_split("//u", $text, -1, PREG_SPLIT_NO_EMPTY);
        $result = '';
        $curOffset = 0;
        $curLen = 0;
        foreach ($array as $char) {
            $utf16 = mb_convert_encoding($char, 'UTF-16');
            if ($curOffset >= $start && $curLen < $length) {
                $result .= $char;
                $curLen += strlen($utf16) > 2 ? 2 : 1;
            }
            $curOffset += strlen($utf16) > 2 ? 2 : 1;
            if ($curLen >= $length) {
                break;
            }
        }
        return $result;
    }

    /**
     * Determine if the text message has any HTML entity.
     *
     * @return bool
     */
    public function hasHtmlEntity()
    {
        foreach ($this->getEntities() ?: [] as $entity) {
            if ($entity->isHtmlEntity()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the caption has any HTML entity.
     *
     * @return bool
     */
    public function hasHtmlCaption()
    {
	    foreach ($this->getCaptionEntities() ?: [] as $entity) {
		    if ($entity->isHtmlEntity()) {
			    return true;
		    }
	    }
	    return false;
    }

    /**
     * Return the HTML code of the text.
     *
     * @return string
     */
    public function getHtml()
    {
        return $this->getTextOrCaptionHtml($this->getText(), $this->getEntities(), 'getEntityText');
    }

    /**
     * Return the HTML code of the caption.
     *
     * @return string
     */
    public function getCaptionHtml()
    {
        return $this->getTextOrCaptionHtml($this->getCaption(), $this->getCaptionEntities(), 'getCaptionEntityText');
    }

    /**
     * @param  string  $text
     * @param  MessageEntity[] $entities
     * @param  string  $getEntityText
     * @return string
     *
     * @internal param $retriever
     *
     */
    protected function getTextOrCaptionHtml($text, $entities, $getEntityText)
    {
        $html = '';
        $lastOffset = 0;
        foreach ($entities ?: [] as $entity) {
            $html .= e($this->substr($text, $lastOffset, $entity->getOffset() - $lastOffset));
            $lastOffset = $entity->getOffset() + $entity->getLength();
            if ($entity->getType() === 'bold') {
                $html .= '<b>'.e($this->$getEntityText($entity)).'</b>';
            } elseif ($entity->getType() === 'italic') {
                $html .= '<i>'.e($this->$getEntityText($entity)).'</i>';
            } elseif ($entity->getType() === 'code') {
                $html .= '<code>'.e($this->$getEntityText($entity)).'</code>';
            } elseif ($entity->getType() === 'pre') {
                $html .= '<pre>'.e($this->$getEntityText($entity)).'</pre>';
            } elseif ($entity->getType() === 'text_link') {
                $url = $entity->getUrl();
                $html .= "<a href=\"$url\">".e($this->$getEntityText($entity)).'</a>';
            } elseif ($entity->getType() === 'text_mention') {
                $url = 'tg://user?id='.$entity->getUser()->getId();
                $html .= "<a href=\"$url\">".e($this->$getEntityText($entity)).'</a>';
            } else {
                $html .= e($this->$getEntityText($entity));
            }
        }

        $html .= e($this->substr($text, $lastOffset, mb_strlen($text)));
        return $html;
    }

    /**
     * Return the file id of the message (if any)
     *
     * @return string|null
     */
    public function getFileId()
    {
        if ($this->getAudio()) {
            return $this->getAudio()->getFileId();
        } elseif ($this->getDocument()) {
            return $this->getDocument()->getFileId();
        } elseif ($this->getNewChatPhoto()) {
            return $this->getNewChatPhoto()->last()->getFileId();
        } elseif ($this->getPhoto()) {
            return $this->getPhoto()->last()->getFileId();
        } elseif ($this->getSticker()) {
            return $this->getSticker()->getFileId();
        } elseif ($this->getVideo()) {
            return $this->getVideo()->getFileId();
        } elseif ($this->getVoice()) {
            return $this->getVoice()->getFileId();
        } elseif ($this->getVideoNote()) {
            return $this->getVideoNote()->getFileId();
        }
    }

    /**
     * Detect type based on properties.
     *
     * @return string|null
     */
    public function detectType()
    {
        $types = [
            'text',
            'audio',
            'document',
            // 'animation', disable animation type here for backward compatibility.
            'photo',
            'sticker',
            'video',
            'voice',
            'video_note',
            'contact',
            'location',
            'venue',
            'new_chat_member',
            'left_chat_member',
            'new_chat_title',
            'new_chat_photo',
            'delete_chat_photo',
            'group_chat_created',
            'supergroup_chat_created',
            'channel_chat_created',
            'migrate_to_chat_id',
            'migrate_from_chat_id',
            'pinned_message',
            'invoice',
            'successful_payment',
        ];

        return $this->keys()
            ->intersect($types)
            ->pop();
    }
}
