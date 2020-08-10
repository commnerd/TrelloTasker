<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace TrelloTasker;

use TrelloTasker\Config;
use Tasker\Group;
use Iterator;

class Tasker implements Iterator
{
    /**
     * Grouping of boards
     *
     * @var $boards
     */
    private array $boards = [];

    /**
     * Iterator index for Iterator implementation
     */
    private int $iteratorIndex = 0;

    public function __constructor(Config $config) {

    }

    /**
     * Get current task to support Iterator interface
     *
     * @return Group
     */
    public function current() : Group {
        $this->groups[$this->iteratorIndex];
    }

    /**
     * Get current key to support Iterator interface
     *
     * @return int
     */
    public function key() : int {
        return $this->iteratorIndex;
    }

    /**
     * Increment task index to support Iterator interface
     *
     * @return void
     */
    public function next () : void
    {
        $this->iteratorIndex++;
    }

    /**
     * Decrement task index to support Iterator interface
     *
     * @return void
     */
    public function rewind () : void
    {
        $this->iteratorIndex--;
    }

    /**
     * Return true if current task is valid, else false to support Iterator interface
     *
     * @return boolean
     */
    public function valid() : bool
    {
        return !!$this->boards[$this->iteratorIndex];
    }
}