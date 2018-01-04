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

<h3>Wich period</h3>
<select id="period">
<?php foreach ($this->periods as $period) : ?>
    <option value="<?php echo $period->id ?>"><?php echo $period->name ?>&nbsp;-&nbsp;<?php echo $period->hour ?></option>
<?php endforeach; ?>
</select>
<a href="#" id="period-save">Next</a>
