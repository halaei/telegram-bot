<?php

namespace Telegram\Bot\Objects;

/**
 * Class OrderInfo.
 *
 * @method String           getName()               (Optional). User name.
 * @method String           getPhoneNumber()        (Optional). User's phone number.
 * @method String           getEmail()              (Optional). User email.
 * @method ShippingAddress  getShippingAddress()    (Optional). User shipping address.
 */
class OrderInfo extends BaseObject
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
