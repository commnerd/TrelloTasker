<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace Tests\Api;

use TrelloTasker\Api\Exceptions\EndpointNeedsPathException;
use Tests\Fixtures\Api\PathlessEndpoint;
use TrelloTasker\Api\BoardsEndpoint;
use TrelloTasker\Api\Endpoint;
use TrelloTasker\Api\Client;
use TrelloTasker\Config;
use Tests\TestCase;

class ClientTest extends TestCase
{
    protected Client $client;

    public function setUp(): void
    {
        $this->client = new Client(new Config());

        parent::setUp();
    }

    public function testClientInitializes()
    {
        $client = new Client(new Config());

        $this->assertTrue($client instanceof Client);
    }

    public function testClientRegistersEndpoints()
    {
        $this->assertTrue($this->client->config->get(BoardsEndpoint::class) instanceof Endpoint);
    }

    public function testClientReturnsBoards()
    {
        $response = file_get_contents(__DIR__."/../Fixtures/Api/Responses/BoardsResponse.json");


        $this->assertNotEmpty($this->client->getBoards());
    }
}