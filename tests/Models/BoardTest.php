<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace Tests\Models;

use TrelloTasker\Models\CardList;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

class BoardTest extends TestCase {

    public function testLists()
    {
        $this->setupMocks([
            new Response(200, [], file_get_contents(__DIR__."/../Fixtures/Api/Responses/BoardResponse.json")),
            new Response(200, [], file_get_contents(__DIR__."/../Fixtures/Api/Responses/ListsResponse.json"))
        ]);

        $lists = $this->tasker->board('foo')->lists();

        $this->assertTrue($lists[0] instanceof CardList);
    }

    public function testList()
    {
        $this->setupMocks([
            new Response(200, [], file_get_contents(__DIR__."/../Fixtures/Api/Responses/BoardResponse.json")),
            new Response(200, [], file_get_contents(__DIR__."/../Fixtures/Api/Responses/ListResponse.json"))
        ]);

        $list = $this->tasker->board('foo')->list("bar");

        $this->assertTrue($list instanceof CardList);
        $this->assertEquals("Today", $list->getTitle());

        $this->assertEquals(null, $list->getDeletedAt());
        $this->assertEquals(null, $list->getParentGroup());
    }

}