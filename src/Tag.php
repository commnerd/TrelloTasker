<?php
/**
 * @author Michael J. Miller <commnerd@gmail.com>
 */
namespace TrelloTasker;

use Tasker\Traits\Grouped;
use Tasker\Traits\Titled;

use Tasker\Tag as BaseTag;

/**
 * Interface for tag entity
 */
final class Tag extends BaseTag
{
    use Grouped, Titled;
}