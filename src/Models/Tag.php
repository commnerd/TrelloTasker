<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace TrelloTasker\Models;

use Tasker\Tag as TaskerTag;

use Tasker\Traits\Grouped;
use Tasker\Traits\Titled;

use Tasker\Group;

class Tag extends TaskerTag
{
    use Grouped, Titled;

    public function __construct(
        string $title,
        Group $group
    )
    {
        $this->setTitle($title);
        $this->setParentGroup($group);
    }
}