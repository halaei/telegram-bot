<?php

namespace Telegram\Bot\Objects;

/**
 * Class ChatMember
 *
 *
 * @method User      getUser()               Information about the user.
 * @method int       getUntilDate()          (Optional). Restictred and kicked only. Date when restrictions will be lifted for this user, unix time.
 * @method bool      canBeEdited()           (Optional). Administrators only. True, if the bot is allowed to edit administrator privileges of that user.
 * @method bool      canChangeInfo()         (Optional). Administrators only. True, if the administrator can change the chat title, photo and other settings.
 * @method bool      canPostMessages()       (Optional). Administrators only. True, if the administrator can post in the channel, channels only.
 * @method bool      canEditMessages()       (Optional). Administrators only. True, if the administrator can edit messages of other users, channels only.
 * @method bool      canDeleteMessages()     (Optional). Administrators only. True, if the administrator can delete messages of other users.
 * @method bool      canInviteUsers()        (Optional). Administrators only. True, if the administrator can invite new users to the chat.
 * @method bool      canRestrictMembers()    (Optional). Administrators only. True, if the administrator can restrict, ban or unban chat members.
 * @method bool      canPinMessages()        (Optional). Administrators only. True, if the administrator can pin messages, supergroups only.
 * @method bool      canPromoteMembers()     (Optional). Administrators only. True, if the administrator can add new administrators with a subset of his own privileges or demote administrators that he has promoted, directly or indirectly (promoted by administrators that were appointed by the user).
 * @method bool      canSendMessages()       (Optional). Restricted only. True, if the user can send text messages, contacts, locations and venues.
 * @method bool      canSendMediaMessages()  (Optional). Restricted only. True, if the user can send audios, documents, photos, videos, video notes and voice notes, implies can_send_messages.
 * @method bool      canSendOtherMessages()  (Optional). Restricted only. True, if the user can send animations, games, stickers and use inline bots, implies can_send_media_messages.
 * @method bool      canAddWebPagePreviews() (Optional). Restricted only. True, if user may add web page previews to his messages, implies can_send_media_messages.
 */
class ChatMember extends BaseObject
{
    /**
     * Property relations.
     *
     * @return array
     */
    public function relations()
    {
        return [
            'user' => User::class,
        ];
    }

    /**
     * The member's status in the chat. Can be "creator", "administrator", "member", "left" or "kicked".
     *
     * @return string
     */
    public function getStatus()
    {
        return $this['status'];
    }
}
