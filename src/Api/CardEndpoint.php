<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace TrelloTasker\Api;

use TrelloTasker\Api\Endpoint;

/**
 * Endpoint to retrieve the available Trello boards
 */
class CardEndpoint extends Endpoint {
    const PATH = "https://api.trello.com/1/cards/{id}";

    const VERBS = ["GET"];
}