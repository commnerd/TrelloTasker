<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace TrelloTasker\Api;

use TrelloTasker\Api\Exceptions\EndpointNeedsVerbsException;
use TrelloTasker\Api\Exceptions\EndpointNeedsPathException;

/**
 * Abstract endpoint class for use in client
 */
abstract class Endpoint
{
    const PATH = "";

    const VERBS = [];

    public function __construct() {
        if(empty(get_called_class()::PATH)) {
            throw new EndpointNeedsPathException("Please set 'const PATH' in ".get_called_class()." (eg. https://api.trello.com/1/members/me/boards.");
        }

        if(empty(get_called_class()::VERBS)) {
            throw new EndpointNeedsVerbsException("Please set array of 'const VERBS' in ".get_called_class()." (eg. GET, PUT, ...).");
        }
    }

    public function getPath(): string {
        return $this->path;
    }
}