<?php

namespace Telegram\Bot\Objects;

/**
 * @method string  getUrl()                   Webhook URL, may be empty if webhook is not set up.
 * @method bool    getHasCustomCertificate()  True, if a custom certificate was provided for webhook certificate checks.
 * @method int     getPendingUpdateCount()    Number of updates awaiting delivery.
 * @method int     getLastErrorDate()         (Optional). Unix time for the most recent error that happened when trying to deliver an update via webhook.
 * @method string  getLastErrorMessage()      (Optional). Error message in human-readable format for the most recent error that happened when trying to deliver an update via webhook.
 */
class WebhookInfo extends BaseObject
{
    /**
     * Property relations.
     *
     * @return array
     */
    public function relations()
    {
        return [];
    }
}
