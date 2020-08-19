<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace TrelloTasker\Traits;

/**
 * Implementation of the IDed interface
 */
trait IDed
{
    protected string $id;

    public function getID(): string
    {
        return $this->id;
    }

    public function setID(string $id)
    {
        $this->id = $id;
    }
}