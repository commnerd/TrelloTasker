<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace Tests\Fixtures\Api;

use TrelloTasker\Api\Endpoint;

class PathlessEndpoint extends Endpoint
{
    const VERBS = ["GET", "PUT"];
}