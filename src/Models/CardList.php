<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace TrelloTasker\Models;

use TrelloTasker\Traits\Taskered;
use TrelloTasker\Models\Card;

use Tasker\Traits\Tombstoned;
use Tasker\Traits\Described;
use Tasker\Traits\Grouped;
use Tasker\Traits\Titled;
use Tasker\Traits\Tagged;
use Tasker\Traits\Dated;
use Tasker\Traits\IDed;

use Tasker\Group;
use Tasker\Task;
use DateTime;

/**
 * Trello List model
 */
class CardList extends Group
{
    use Taskered, IDed, Titled, Described, Tagged, Dated, Tombstoned, Grouped;

    private array $cards = [];
    private int $cardIndex = -1;

    public function __construct(
        string $id,
        string $title,
        array $cards = [],
        array $tags = [],
        DateTime $created_at = null,
        DateTime $updated_at = null,
        DateTime $deleted_at = null
    )
    {
        $this->setId($id);
        $this->setTitle($title);
        foreach($cards as $card) {
            $this->cards[] = $card;
        }
        foreach($tags as $color => $name) {
            $this->addTag(new Tag(
                $name ?? $color,
                $this
            ));
        }
        $this->setCreatedAt($created_at ?? new DateTime("now"));
        $this->setUpdatedAt($updated_at ?? new DateTime("now"));

        if(!is_null($deleted_at)) {
            $this->setDeletedAt($deleted_at);
        }
    }

    /**
     * Implementation of current for Iterator interface
     *
     * @return CardList
     */
    public function current(): CardList {
        return $this->cards[$this->cardIndex];
    }

    /**
     * Implementation of key for Iterator interface
     *
     * @return integer
     */
    public function key(): int
    {
        return $this->cardIndex;
    }

    /**
     * Implementation of next for Iterator interface
     */
    public function next()
    {
        $this->cardIndex++;
    }

    /**
     * Implementation of rewind for Iterator interface
     */
    public function rewind()
    {
        $this->cardIndex--;
    }

    /**
     * Implementation of valid for Iterator interface
     *
     * @return boolean
     */
    public function valid(): bool
    {
        return !empty($this->cards[$this->cardIndex]);
    }

    /**
     * Get the collection of tasks
     *
     * @return iterable|null
     */
    public function getTasks(): array
    {
        return $this->cards;
    }

    /**
     * Add a task
     *
     * @param Task $task
     * @return bool True if task was successfully added, else false
     */
    public function addTask(Task $task): bool
    {
        $this->cards[] = $task;
        return true;
    }

    /**
     * Rmove a task
     *
     * @param Task $task
     * @return bool True if task was successfully removed, else false
     */
    public function removeTask(Task $task): bool
    {
        foreach($this->tasks as $index => $arrayTask) {
            if($task === $arrayTask) {
                array_splice($this->tasks, $index, 1);
                return true;
            }
        }
        return false;
    }

    /**
     * Provide array of cards that belong to this board
     *
     * @return array
     */
    public function cards() : array
    {
        return $this->tasker->cards($this->id);
    }

    /**
     * Provide card that belongs to this board
     *
     * @return array
     */
    public function card(string $id) : Card
    {
        return $this->tasker->card($id);
    }
}