<?php

namespace Telegram\Bot\Objects;

/**
 * Class ShippingQuery.
 *
 *
 * @method string           getId()                 Unique query identifier.
 * @method User             getFrom()               User who sent the query.
 * @method string           getInvoicePayload()     Bot specified invoice payload.
 * @method ShippingAddress  getShippingAddress()    User specified shipping address.
 */

class ShippingQuery extends BaseObject
{
    /**
     * Property relations.
     *
     * @return array
     */
    public function relations()
    {
        return [
            'shipping_address' => ShippingAddress::class,
        ];
    }
}
