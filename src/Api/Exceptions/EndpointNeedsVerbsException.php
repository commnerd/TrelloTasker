<?php
/**
 * Endpoint to retrieve the available Trello boards
 */
namespace TrelloTasker\Api\Exceptions;

/**
 * Exception thrown when an endpoint doesn't contain an array of applicable verbs
 */
class EndpointNeedsVerbsException extends \Exception
{}