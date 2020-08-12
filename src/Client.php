<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace TrelloTasker;

use TrelloTasker\Api\BoardsEndpoint;
use TrelloTasker\Api\Endpoint;
use TrelloTasker\Config;

/**
 * Trello Api Client
 */
class Client
{
    const ENDPOINTS = [
        BoardsEndpoint::class,
    ];

    public Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->initializeEndpoints();
    }

    public function getBoards(): array
    {
        $endpoint = $this->config->get(BoardsEndpoint::class);

        $result = json_decode(file_get_contents(__DIR__.'/../tests/Fixtures/Api/Responses/BoardsResponse.json'));

        return $result;

    }

    private function initializeEndpoints()
    {
        foreach(self::ENDPOINTS as $class) {
            $this->config->set($class, new $class);
        }
    }

    private function call(Endpoint $endpoint): string
    {
        return "";
    }
}