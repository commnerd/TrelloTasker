<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace Tests;

use TrelloTasker\Models\CardList;
use TrelloTasker\Models\Board;
use TrelloTasker\Models\Card;
use TrelloTasker\Models\Tag;

use GuzzleHttp\Psr7\Response;


class TrelloTaskerTest extends TestCase
{
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
            new Response(200, [], file_get_contents(__DIR__."/Fixtures/Api/Responses/ListsResponse.json"))
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

    public function testCards()
    {
        $this->setupMocks([
            new Response(200, [], file_get_contents(__DIR__."/Fixtures/Api/Responses/CardsResponse.json"))
        ]);

        $cards = $this->tasker->cards("abc");

        $this->assertTrue($cards[0] instanceof Card);
    }

    public function testCard()
    {
        $this->setupMocks([
            new Response(200, [], file_get_contents(__DIR__."/Fixtures/Api/Responses/CardResponse.json"))
        ]);

        $card = $this->tasker->card('foo');

        $this->assertTrue($card instanceof Card);
        $this->assertEquals("Build Jasper's play house", $card->getTitle());

        $this->assertEquals(null, $card->getDeletedAt());
        $this->assertEquals(null, $card->getParentGroup());
    }
}