<?php
/**
 * @package     racol
 * @subpackage  com_booking
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;


?>
<ul>
<?php foreach ($this->items as $item):
    $link = JRoute::_(BookingHelperRoute::getFormuleRoute($item->id));
    ?>
    <li>
    <a href="<?php echo $link?>">
        <?php echo $item->name ?>
    </a>
    <?php echo $item->price ?>
    </li>
<?php endforeach ?>
</ul>
