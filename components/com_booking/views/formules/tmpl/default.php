<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;


?>
<?php foreach ($this->items as $item):
    $link = JRoute::_(BookingHelperRoute::getFormuleRoute($item->id));
    ?>
    <a href="<?php echo $link?>">
        <?php echo $item->name ?>
    </a>
    <?php echo $item->price ?>

<?php endforeach ?>
