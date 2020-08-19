<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace TrelloTasker;

use TrelloTasker\Api\BoardsEndpoint;
use TrelloTasker\Api\BoardEndpoint;
use TrelloTasker\Api\ListsEndpoint;
use TrelloTasker\Api\ListEndpoint;

use TrelloTasker\Models\CardList;
use TrelloTasker\Models\Board;
use TrelloTasker\Config;
use GuzzleHttp\Client;
use Tasker\Group;
use Iterator;

class TrelloTasker implements Iterator
{
    /**
     * Endpoints to be used in this client
     */
    const ENDPOINTS = [
        BoardsEndpoint::class,
        BoardEndpoint::class,
        ListsEndpoint::class,
        ListEndpoint::class,
    ];

    /**
     * Config for the app
     *
     * @var $config
     */
    private Config $config;

    /**
     * Guzzle client
     */
    private Client $client;

    /**
     * Grouping of boards
     *
     * @var $boards
     */
    private array $boards = [];

    /**
     * Iterator index for Iterator implementation
     */
    private int $iteratorIndex = 0;

    public function __construct(
        Config $config,
        Client $client = null
    )
    {
        $this->config = $config;
        if(is_null($client)) {
            $client = new Client();
        }
        $this->client = $client;
        $this->initializeEndpoints();
    }

    /**
     * Get current task to support Iterator interface
     *
     * @return Group
     */
    public function current(): Group {
        $this->groups[$this->iteratorIndex];
    }

    /**
     * Get current key to support Iterator interface
     *
     * @return int
     */
    public function key(): int {
        return $this->iteratorIndex;
    }

    /**
     * Increment task index to support Iterator interface
     *
     * @return void
     */
    public function next(): void
    {
        $this->iteratorIndex++;
    }

    /**
     * Decrement task index to support Iterator interface
     *
     * @return void
     */
    public function rewind(): void
    {
        $this->iteratorIndex--;
    }

    /**
     * Return true if current task is valid, else false to support Iterator interface
     *
     * @return boolean
     */
    public function valid(): bool
    {
        return !!$this->boards[$this->iteratorIndex];
    }

    /**
     * Get Trello boards
     *
     * @return array
     */
    public function boards(): array
    {
        $endpoint = $this->config->get(BoardsEndpoint::class);
        $boards = [];

        $response = $this->client->get($endpoint::PATH);

        $structure = json_decode($response->getBody());

        foreach($structure as $listing) {
            $boards[] = new Board(
                $listing->name,
                $listing->desc,
                [],
                (array)$listing->labelNames,
            );
        }

        return $boards;
    }

    /**
     * Get Trello board by id
     *
     * @param string $id
     * @return Board
     */
    public function board(string $id): Board
    {
        $endpoint = $this->config->get(BoardEndpoint::class);

        $path = str_replace("{id}", $id, $endpoint::PATH);
        $response = $this->client->get($path);

        $structure = json_decode($response->getBody());

        return new Board(
            $structure->name,
            $structure->desc ?? '',
            [],
            (array)$structure->labelNames ?? [],
        );
    }

    /**
     * Get list of a board's lists
     *
     * @param string $boardId
     * @return array
     */
    public function lists(string $boardId): array
    {
        $endpoint = $this->config->get(ListsEndpoint::class);
        $lists = [];
        $path = str_replace("{id}", $boardId, $endpoint::PATH);

        $response = $this->client->get($path);

        $structure = json_decode($response->getBody());

        foreach($structure as $listing) {
            $lists[] = new CardList(
                $listing->name,
            );
        }

        return $lists;
    }

    /**
     * Get list definition
     *
     * @param string $listId
     * @return CardList
     */
    public function list(string $listId): CardList
    {
        $endpoint = $this->config->get(ListEndpoint::class);
        $path = str_replace("{id}", $listId, $endpoint::PATH);

        $response = $this->client->get($path);

        $structure = json_decode($response->getBody());

        return new CardList(
            $structure->name,
        );
    }

    /**
     * Load endpoints into the config
     *
     * @return void
     */
    private function initializeEndpoints()
    {
        foreach(self::ENDPOINTS as $class) {
            $this->config->set($class, new $class);
        }
    }
}