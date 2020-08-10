<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace TrelloTasker\Api;

interface WebClient
{
    public function setOption($name, $value);
    public function execute();
    public function getInfo($name);
    public function close();
}