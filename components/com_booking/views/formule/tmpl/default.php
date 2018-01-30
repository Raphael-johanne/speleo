<?php
/**
 * @package     racol
 * @subpackage  com_booking
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
JHtml::_('jquery.framework');
JHtml::script(Juri::base() . 'templates/booking/js/lib/jqueryui.min.js');
JHtml::script(Juri::base() . 'templates/booking/js/lib/i18n/datepicker-fr.js');
JHtml::script(Juri::base() . 'templates/booking/js/lib/i18n/datepicker-en-GB.js');
//JHtml::script(Juri::base() . 'templates/booking/js/booking.js');
?>

<?php if ($this->item->lat && $this->item->lng): ?>
    <style>
        #booking-map {
            height: 400px;
            width: 100%;
        }
    </style>
    <a href="#" id="booking-map-link"><?php echo JText::_('COM_BOOKING_SEE_ON_MAP'); ?></a>
    <div id="booking-map"></div>
    <script>
        function initMap() {
            var place = {lat: <?php echo $this->item->lat ?>, lng: <?php echo $this->item->lng ?>};
            var map = new google.maps.Map(document.getElementById('booking-map'), {
                zoom: 4,
                center: place
            });
            var marker = new google.maps.Marker({
                position: place,
                map: map
            });
        }
    </script>

    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=GOOGLE_API_KEY&callback=initMap">
    </script>

<?php endif;?>

<h1>
    <?php echo $this->item->name ?>
</h1>
<ul>
    <li>
        <?php echo $this->item->description ?>
    </li>
    <li>
        <?php echo $this->item->program ?>
    </li>
    <li>
        <?php echo $this->item->price ?>
    </li>
</ul>

<div id="errors">&nbsp;</div>
<div id="overview">&nbsp;</div>
<div id="booking">&nbsp;</div>

<a href="#" id="cancel-step"><?php echo JText::_('COM_BOOKING_PREVIOUS') ?></a>
<a href="#" id="save-step"><?php echo JText::_('COM_BOOKING_NEXT') ?></a>

<script type="application/javascript">
    const booking = new Booking(
        'index.php?option=com_booking',
        'booking',
        'overview',
        'errors',
        <?php echo $this->item->id ?>,
        '<?php echo $this->localeTag ?>'
    );
    booking.loadStep();
</script>
