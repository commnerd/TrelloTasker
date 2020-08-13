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

use Tasker\Task;
use DateTime;

class Card extends Task
{
    use Titled, Described, Tagged, Dated, Tombstoned, Grouped;

    public function __constructor(
        string $title,
        string $description = [],
        array $tags = [],
        DateTime $created_at = new DateTime("now"),
        DateTime $updated_at = new DateTime("now"),
        DateTime $deleted_at = null
    )
    {
        $this->setTitle($title);
        $this->setDescription($description);
        foreach($tags as $color => $name) {
            $this->addTag(new Tag(
                $name ?? $color,
                $this
            ));
        }
        $this->setCreatedAt($created_at);
        $this->setUpdatedAt($updated_at);
        $this->setDeletedAt($deleted_at);
    }
}