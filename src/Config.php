<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace TrelloTasker;

class Config
{
    private $settings = [];

    public function __construct(array $settings = [])
    {
        $this->settings = $settings;
    }

    public function get($key)
    {
        return $this->settings[$key];
    }

    public function set($key, $val): void
    {
        $this->settings[$key] = $val;
    }
}