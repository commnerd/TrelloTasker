<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace Tasker;

use Tasker\Interfaces\Tombstoned;
use Tasker\Interfaces\Described;
use Tasker\Interfaces\Grouped;
use Tasker\Interfaces\Titled;
use Tasker\Interfaces\Tagged;
use Tasker\Interfaces\Dated;
use Tasker\Task;
use Iterator;

/**
 * A class for grouping tasks
 */
abstract class Group implements Titled, Described, Tagged, Dated, Tombstoned, Grouped, Iterator {
    /**
     * Get the collection of tasks
     *
     * @return iterable|null
     */
    public abstract function getTasks(): ?iterable;

    /**
     * Add a task
     *
     * @param Task $task
     * @return bool True if task was successfully added, else false
     */
    public abstract function addTask(Task $task): bool;

    /**
     * Rmove a task
     *
     * @param Task $task
     * @return bool True if task was successfully removed, else false
     */
    public abstract function removeTask(Task $task): bool;
}