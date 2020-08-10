<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace TrelloTasker\Api;

class CurlClient implements WebClient
{
    private $handle = null;

    public function __construct($url) {
        $this->handle = curl_init($url);
    }

    public function setOption($name, $value) {
        curl_setopt($this->handle, $name, $value);
    }

    public function execute() {
        return curl_exec($this->handle);
    }

    public function getInfo($name) {
        return curl_getinfo($this->handle, $name);
    }

    public function close() {
        curl_close($this->handle);
    }
}