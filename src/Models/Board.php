<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace TrelloTasker\Models;

use Tasker\Interfaces\Group;

use Tasker\Traits\Tombstoned;
use Tasker\Traits\Described;
use Tasker\Traits\Grouped;
use Tasker\Traits\Titled;
use Tasker\Traits\Tagged;
use Tasker\Traits\Dated;

use DateTime;

/**
 * Trello Board model
 */
class Board extends Group
{

    use Titled, Described, Tagged, Dated, Tombstoned, Grouped;

    public function __construct(
        string $title = '',
        string $description = '',
        array $tags,
        DateTime $created_at = DateTime("now"),
        DateTime $updated_at = DateTime("now"),
        DateTime $deleted_at = null,
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
    }
}