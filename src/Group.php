<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace Tasker;

use Tasker\Group as TaskerGroup;

use Iterator;

/**
 * A class for grouping tasks
 */
abstract class Group extends TaskerGroup {
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