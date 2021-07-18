<?php

namespace Telegram\Bot\FileUpload;

use GuzzleHttp\Psr7;
use Psr\Http\Message\StreamInterface;
use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * Class InputFile.
 */
class InputFile implements InputFileInterface
{
    /**
     * @var string|resource The path to the file on the system, or the readable resource.
     */
    protected $path;

    /**
     * @var null|string The uri of the resource.
     * If set, Telegram will use this as the original file name.
     */
    private $uri;

    /**
     * Creates a new InputFile entity.
     *
     * @param string|resource $filePath
     * @param string|null $uri
     *
     * @throws TelegramSDKException
     */
    public function __construct($filePath, $uri = null)
    {
        $this->path = $filePath;
        $this->uri = $uri;
    }

    /**
     * Opens file stream as an StreamInterface.
     *
     * @throws TelegramSDKException
     *
     * @return StreamInterface
     */
    public function open()
    {
        $resource = $this->getResource();
        $options = [];
        if (! is_null($this->uri)) {
            $options = ['metadata' => ['uri' => $this->uri]];
        }

        return new Psr7\Stream($resource, $options);
    }

    /**
     * Opens file stream as a resource.
     *
     * @throws TelegramSDKException
     *
     * @return resource
     */
    protected function getResource()
    {
        if (is_resource($this->path)) {
            return $this->path;
        }

        if (!$this->isRemoteFile() && !is_readable($this->path)) {
            throw new TelegramSDKException('Failed to create InputFile entity. Unable to read resource: '.$this->path.'.');
        }

        return Psr7\Utils::tryFopen($this->path, 'rb');
    }

    /**
     * Returns true if the path to the file is remote.
     *
     * @return bool
     */
    protected function isRemoteFile()
    {
        return preg_match('/^(https?|ftp):\/\/.*/', $this->path) === 1;
    }
}
