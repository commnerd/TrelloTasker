<?php
/**
 * Endpoint to retrieve the available Trello boards
 */
namespace TrelloTasker\Api\Exceptions;

/**
 * Exception thrown when an endpoint doesn't contain a defined path
 */
class EndpointNeedsPathException extends \Exception
{}