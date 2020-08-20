<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace TrelloTasker;

use TrelloTasker\Api\BoardsEndpoint;
use TrelloTasker\Api\BoardEndpoint;
use TrelloTasker\Api\ListsEndpoint;
use TrelloTasker\Api\CardsEndpoint;
use TrelloTasker\Api\ListEndpoint;
use TrelloTasker\Api\CardEndpoint;

use TrelloTasker\Models\CardList;
use TrelloTasker\Models\Board;
use TrelloTasker\Models\Card;
use TrelloTasker\Config;
use GuzzleHttp\Client;
use Tasker\Group;
use DateTime;

class TrelloTasker
{
    /**
     * Endpoints to be used in this client
     */
    const ENDPOINTS = [
        BoardsEndpoint::class,
        BoardEndpoint::class,
        ListsEndpoint::class,
        CardsEndpoint::class,
        ListEndpoint::class,
        CardEndpoint::class,
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
            $board = new Board(
                $listing->id,
                $listing->name,
                $listing->desc,
                [],
                (array)$listing->labelNames,
            );

            $board->setTrelloTasker($this);
            $boards[] = $board;
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

        $board = new Board(
            $structure->id,
            $structure->name,
            $structure->desc ?? '',
            [],
            (array)$structure->labelNames ?? [],
        );

        $board->setTrelloTasker($this);

        return $board;
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
            $list = new CardList(
                $listing->id,
                $listing->name,
            );
            $list->setTrelloTasker($this);
            $lists[] = $list;
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

        $list = new CardList(
            $structure->id,
            $structure->name,
        );
        $list->setTrelloTasker($this);
        return $list;
    }

    /**
     * Get list of a list's cards
     *
     * @param string $listId
     * @return array
     */
    public function cards(string $listId): array
    {
        $endpoint = $this->config->get(CardsEndpoint::class);
        $cards = [];
        $path = str_replace("{id}", $listId, $endpoint::PATH);

        $response = $this->client->get($path);

        $structure = json_decode($response->getBody());

        foreach($structure as $listing) {
            $cards[] = new Card(
                $listing->id,
                $listing->name,
            );
        }

        return $cards;
    }

    /**
     * Get card definition
     *
     * @param string $cardId
     * @return Card
     */
    public function card(string $cardId): Card
    {
        $endpoint = $this->config->get(CardEndpoint::class);
        $path = str_replace("{id}", $cardId, $endpoint::PATH);

        $response = $this->client->get($path);

        $structure = json_decode($response->getBody());

        return new Card(
            $structure->id,
            $structure->name,
            $structure->desc,
            new DateTime($structure->dateLastActivity),
            new DateTime($structure->dateLastActivity)
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