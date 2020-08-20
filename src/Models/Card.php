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

use Tasker\Task;
use DateTime;

class Card extends Task
{
    use IDed, Titled, Described, Tagged, Dated, Tombstoned, Grouped;

    public function __construct(
        string $id,
        string $title,
        string $description = "",
        DateTime $created_at = null,
        DateTime $updated_at = null,
        DateTime $deleted_at = null
    )
    {
        $this->setId($id);
        $this->setTitle($title);
        $this->setDescription($description);

        $this->setCreatedAt($created_at ?? new DateTime("now"));
        $this->setUpdatedAt($updated_at ?? new DateTime("now"));

        if(!is_null($deleted_at)) {
            $this->setDeletedAt($deleted_at);
        }
    }
}