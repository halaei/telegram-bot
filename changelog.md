# Version 0.9.0
- Laravel 8.x only
- Bugfix InputFile::open().

# Version 0.8.1
- Support Laravel 8.*
- Support for PHP 8.0
- More Cause functions
# Version 0.8.0
- Stop supporting PHP 7.1, 7.0 and 5.*
- Stop supporting Laravel 5.7
- Support Laravel 6 and 7

# Version 0.7.0
- Support for Bot API 4.3

# Version 0.6.0
- Partial support for Bot API 4.1 (Passport not implemented yet).
- Support for Bot API 3.6.
- Support for multipart attachments.
- Add methods `Message::getCaptionHtml()` and `Message::hasHtmlCaption()`.
- Add method `TelegramResponseException::retryAfter()`.

# Version 0.5.0

- Move some logic from `Api` to `TelegramRequest`, so that `TelegramRequest::params` represents the params passed to `Api` methods.
- Support for Bot Api 3.4.
- Add Message::getCaptionEntityText() method.

# Version 0.4.0

## Added
- The API functions now accept alternative bot access token via `$params['_AccessToken_']`:
```php
$api = new \Telegram\Bot\Api();
$api->sendMessage([
    '_AccessToken_' => '123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11',
    'chat_id'       => 12341234,
    'text'          => 'test',
]);
```

- A new `Api::onSending` event handler is introduced.

## Changed
- Add `Closure $parser = null` parameter to `Api::uploadFile()` protected function.
- Add `$token` parameter to `Api::sendRequest()` and `Api::request` protected functions.
- Changes interaction between `Api::uploadFile()` and `Api::post()` protected functions.

## Fixed
- Fix `setChatPhoto()`, `createNewStickerSet()`, `addStickerToSet()`, and `uploadStickerFile()`.

## Removed
- The deprecated `Telegram\Keyboard` classes and keyboard related functions in `Telegram\Api` class are removed.
