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

Hello,

You have subribe to the formule <?php echo $this->formule->name ?> on our site:
<ul>
    <li>
        Firstname : <?php echo $this->booking->firstname ?>
    </li>
    <li>
        Lastname : <?php echo $this->booking->lastname ?>
    </li>
    <li>
        Email : <?php echo $this->booking->email ?>
    </li>
    <li>
        Person number : <?php echo $this->booking->nbr_person ?>
    </li>
    <li>
        Date : <?php echo $this->booking->date ?>
    </li>
    <li>
        Period : <?php echo $this->booking->name ?> - <?php echo $this->booking->hour ?>
    </li>
</ul>
<br />
<b>You have one hour to comfirm your subscription else it will be automatically canceled.</b>
<br />
<b>To do it, please follow this link :</b>
<br />
<br />
<a href="<?php echo JURI::root() . $this->comfirmLink ?>">Comfirm your subscription</a>
<br />
<br />
Thanks again !
