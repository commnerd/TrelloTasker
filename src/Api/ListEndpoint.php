<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace TrelloTasker\Api;

use TrelloTasker\Api\Endpoint;

/**
 * Endpoint to retrieve the available Trello boards
 */
class ListEndpoint extends Endpoint {
    const PATH = "https://api.trello.com/1/lists/{id}";

    const VERBS = ["GET"];
}