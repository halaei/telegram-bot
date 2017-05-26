<?php

namespace Telegram\Bot\Objects;

/**
 * Class SuccessfulPayment.
 *
 * @method string       getCurrency()                   Three-letter ISO 4217 currency code.
 * @method int          getTotalAmount()                Total price in the smallest units of the currency (integer, not float/double). For example, for a price of US$ 1.45 pass amount = 145. See the exp parameter in currencies.json, it shows the number of digits past the decimal point for each currency (2 for the majority of currencies)..
 * @method string       getInvoicePayload()             Bot specified invoice payload.
 * @method string       getShippingOptionId()           Optional. Identifier of the shipping option chosen by the user.
 * @method OrderInfo    getOrderInfo()                  Optional. Order info provided by the user.
 * @method string       getTelegramPaymentChargeId()    Telegram payment identifier.
 * @method string       getProviderPaymentChargeId()    Provider payment identifier.
 */
class SuccessfulPayment extends BaseObject
{
    /**
     * Property relations.
     *
     * @return array
     */
    public function relations()
    {
        return [
            'order_info' => OrderInfo::class,
        ];
    }
}
