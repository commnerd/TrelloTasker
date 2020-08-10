<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace Tests;

use TrelloTasker\Config;
use stdClass;

class ConfigTest extends TestCase
{
    public function testConfigInitializesWithoutValues()
    {
        $config = new Config();

        $this->assertTrue($config instanceof Config);
    }

    public function testConfigInitializesWithValues()
    {
        $config = new Config([
            'some' => "Config",
            "random" => new stdClass(),
            "stuff" => 1,
            1 => "blubber"
        ]);

        $this->assertEquals($config->get("some"), "Config");
        $this->assertTrue($config->get("random") instanceof stdClass);
        $this->assertEquals($config->get("stuff"), 1);
        $this->assertEquals($config->get(1), "blubber");

    }
}