<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace Tests;

use TrelloTasker\Models\Board;
use TrelloTasker\TrelloTasker;
use TrelloTasker\Config;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;

use stdClass;

class TrelloTaskerTest extends TestCase
{
    private TrelloTasker $tasker;

    public function testGetBoards()
    {
        $this->setupMocks([
            new Response(200, ['X-Foo' => 'Bar'], file_get_contents(__DIR__."/Fixtures/Api/Responses/BoardsResponse.json"))
        ]);

        $boards = $this->tasker->getBoards();

        $this->assertTrue($boards[0] instanceof Board);
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