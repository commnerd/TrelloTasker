<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace TrelloTasker\Api;

use TrelloTasker\Api\Endpoint;

/**
 * Endpoint to retrieve the available Trello boards
 */
class BoardsEndpoint extends Endpoint {
    const PATH = "https://api.trello.com/1/members/me/boards";

    const VERBS = ["GET"];
}