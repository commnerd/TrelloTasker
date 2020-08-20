<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace TrelloTasker\Models;

use Tasker\Traits\Tombstoned;
use Tasker\Traits\Described;
use Tasker\Traits\Grouped;
use Tasker\Traits\Titled;
use Tasker\Traits\Tagged;
use Tasker\Traits\Dated;
use Tasker\Traits\IDed;

use TrelloTasker\Exceptions\NotATaskGroupException;
use TrelloTasker\Traits\Taskered;
use Tasker\Group;
use Tasker\Task;
use DateTime;

/**
 * Trello Board model
 */
class Board extends Group
{
    const NO_TASK_MESSAGE = "Boards do not directly contain tasks.";

    use Taskered, IDed, Titled, Described, Tagged, Dated, Tombstoned, Grouped;

    private array $cardLists = [];
    private int $cardListIndex = -1;

    public function __construct(
        string $id,
        string $title,
        string $description = '',
        array $cardLists = [],
        array $tags = [],
        DateTime $created_at = null,
        DateTime $updated_at = null,
        DateTime $deleted_at = null
    )
    {
        $this->setId($id);
        $this->setTitle($title);
        $this->setDescription($description);
        foreach($cardLists as $cardList) {
            $this->cardLists[] = $cardList;
        }
        foreach($tags as $color => $name) {
            $this->addTag(new Tag(
                empty($name) ? $color : $name,
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
        return $this->cardLists[$this->cardListIndex];
    }

    /**
     * Implementation of key for Iterator interface
     *
     * @return int
     */
    public function key(): int
    {
        return $this->cardListIndex;
    }

    /**
     * Implementation of next for Iterator interface
     *
     * @return void
     */
    public function next(): void
    {
        $this->cardListIndex++;
    }

    /**
     * Implementation of rewind for Iterator interface
     *
     * @return void
     */
    public function rewind(): void
    {
        $this->cardListIndex--;
    }

    /**
     * Implementation of valid for Iterator interface
     *
     * @return bool
     */
    public function valid(): bool
    {
        return !empty($this->cardLists[$this->cardListIndex]);
    }

    /**
     * Get the collection of tasks
     *
     * @return iterable|null
     */
    public function getTasks(): array
    {
        throw new NotATaskGroupException(self::NO_TASK_MESSAGE);
    }

    /**
     * Add a task
     *
     * @param Task $task
     * @return bool True if task was successfully added, else false
     */
    public function addTask(Task $task): bool
    {
        throw new NotATaskGroupException(self::NO_TASK_MESSAGE);
    }

    /**
     * Remove a task
     *
     * @param Task $task
     * @return bool True if task was successfully removed, else false
     */
    public function removeTask(Task $task): bool
    {
        throw new NotATaskGroupException(self::NO_TASK_MESSAGE);
    }

    /**
     * Provide array of card lists that belong to this board
     *
     * @return array
     */
    public function lists() : array
    {
        return $this->tasker->lists($this->id);
    }

    /**
     * Provide card list that belongs to this board
     *
     * @return array
     */
    public function list(string $id) : CardList
    {
        return $this->tasker->list($id);
    }
}