<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace Tests;

use TrelloTasker\Models\CardList;
use TrelloTasker\Models\Board;
use TrelloTasker\TrelloTasker;
use TrelloTasker\Models\Tag;
use TrelloTasker\Config;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;

class TrelloTaskerTest extends TestCase
{
    private TrelloTasker $tasker;

    public function testBoards()
    {
        $this->setupMocks([
            new Response(200, [], file_get_contents(__DIR__."/Fixtures/Api/Responses/BoardsResponse.json"))
        ]);

        $boards = $this->tasker->boards();

        $this->assertTrue($boards[0] instanceof Board);
    }

    public function testBoard()
    {
        $this->setupMocks([
            new Response(200, [], file_get_contents(__DIR__."/Fixtures/Api/Responses/BoardResponse.json"))
        ]);

        $board = $this->tasker->board('foo');

        $this->assertTrue($board instanceof Board);
        $this->assertEquals("Chores", $board->getTitle());
        $this->assertEquals("", $board->getDescription());
        $this->assertEquals([
            new Tag("Yard", $board),
            new Tag("yellow", $board),
            new Tag("orange", $board),
            new Tag("red", $board),
            new Tag("purple", $board),
            new Tag("House", $board),
            new Tag("sky", $board),
            new Tag("lime", $board),
            new Tag("pink", $board),
            new Tag("black", $board)
        ], $board->getTags());
        $this->assertEquals(null, $board->getDeletedAt());
        $this->assertEquals(null, $board->getParentGroup());
    }

    public function testLists()
    {
        $this->setupMocks([
            new Response(200, [], file_get_contents(__DIR__."/Fixtures/Api/Responses/BoardsResponse.json"))
        ]);

        $lists = $this->tasker->lists("abc");

        $this->assertTrue($lists[0] instanceof CardList);
    }

    public function testList()
    {
        $this->setupMocks([
            new Response(200, [], file_get_contents(__DIR__."/Fixtures/Api/Responses/ListResponse.json"))
        ]);

        $list = $this->tasker->list('foo');

        $this->assertTrue($list instanceof CardList);
        $this->assertEquals("Today", $list->getTitle());

        $this->assertEquals(null, $list->getDeletedAt());
        $this->assertEquals(null, $list->getParentGroup());
    }

    private function setupMocks(array $responseStack) {
        // Create a mock and queue two responses.
        $mock = new MockHandler($responseStack);

        $handlerStack = HandlerStack::create($mock);
        $this->client = new Client(['handler' => $handlerStack]);

        $this->config = new Config();
        $this->tasker = new TrelloTasker($this->config, $this->client);
    }
}