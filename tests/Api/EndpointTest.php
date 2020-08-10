<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace Tests\Api;

use TrelloTasker\Api\Exceptions\EndpointNeedsVerbsException;
use TrelloTasker\Api\Exceptions\EndpointNeedsPathException;
use Tests\Fixtures\Api\PathlessEndpoint;
use Tests\Fixtures\Api\VerblessEndpoint;
use Tests\TestCase;

class EndpointTest extends TestCase
{
    public function testPathlessEndpoint()
    {
        $this->expectException(EndpointNeedsPathException::class);

        new PathlessEndpoint();
    }

    public function testVerblessEndpoint()
    {
        $this->expectException(EndpointNeedsVerbsException::class);

        new VerblessEndpoint();
    }
}