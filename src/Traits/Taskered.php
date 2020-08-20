<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace TrelloTasker\Traits;

use TrelloTasker\TrelloTasker;

trait Taskered
{
    protected TrelloTasker $tasker;

    public function setTrelloTasker(TrelloTasker $tasker)
    {
        $this->tasker = $tasker;
    }

    public function getTrelloTasker(): TrelloTasker
    {
        return $this->tasker;
    }
}