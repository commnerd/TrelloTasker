<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace Tests;

use PHPUnit\Framework\TestCase as PhpUnitTestCase;
use GuzzleHttp\Handler\MockHandler;
use TrelloTasker\TrelloTasker;
use GuzzleHttp\HandlerStack;
use TrelloTasker\Config;
use GuzzleHttp\Client;

class TestCase extends PhpUnitTestCase
{
    protected TrelloTasker $tasker;

    /**
    * Call protected/private method of a class.
    *
    * @param object &$object    Instantiated object that we will run method on.
    * @param string $methodName Method name to call
    * @param array  $parameters Array of parameters to pass into method.
    *
    * @return mixed Method return.
    */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    protected function setupMocks(array $responseStack) {
        // Create a mock and queue two responses.
        $mock = new MockHandler($responseStack);

        $handlerStack = HandlerStack::create($mock);
        $this->client = new Client(['handler' => $handlerStack]);

        $this->config = new Config();
        $this->tasker = new TrelloTasker($this->config, $this->client);
    }
}