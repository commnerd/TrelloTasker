<?php

namespace TrelloTasker\Api;

class BoardsEndpoint {
    private string $path = "https://api.trello.com/1/members/me/boards";
    private array $query;

    public function __constructor(string $key, string $token) {
        $this->query = [
            "key" => $key,
            "token" => $token,
        ];
    }
}