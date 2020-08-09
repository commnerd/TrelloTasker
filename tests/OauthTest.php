<?php

namespace Tests;

use TrelloTasker\OAuth;

class OauthTest extends TestCase
{
    public function testGetToken() {
        $auth = new OAuth();
        exit(print_r($auth->getToken(), true));
    }
}