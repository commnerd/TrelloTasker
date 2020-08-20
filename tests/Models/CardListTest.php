<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace Tests\Models;

use TrelloTasker\Models\Card;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

class CardListTest extends TestCase {

    public function testCards()
    {
        $this->setupMocks([
            new Response(200, [], file_get_contents(__DIR__."/../Fixtures/Api/Responses/ListResponse.json")),
            new Response(200, [], file_get_contents(__DIR__."/../Fixtures/Api/Responses/CardsResponse.json"))
        ]);

        $lists = $this->tasker->list('foo')->cards();

        $this->assertTrue($lists[0] instanceof Card);
    }

    public function testCard()
    {
        $this->setupMocks([
            new Response(200, [], file_get_contents(__DIR__."/../Fixtures/Api/Responses/ListResponse.json")),
            new Response(200, [], file_get_contents(__DIR__."/../Fixtures/Api/Responses/CardResponse.json"))
        ]);

        $card = $this->tasker->list('foo')->card("bar");

        $this->assertTrue($card instanceof Card);
        $this->assertEquals("Build Jasper's play house", $card->getTitle());

        $this->assertEquals(null, $card->getDeletedAt());
        $this->assertEquals(null, $card->getParentGroup());
    }

}