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
?>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
  <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>

  <script>
    jQuery(document).ready(function(){
      jQuery('.imagesSlider').bxSlider();
    });
  </script>
<div class="col col-md-8">
    <?php if ($this->item->description): ?>
        <p>
            <?php echo $this->item->description ?>
        </p>
    <?php endif; ?>
    <?php if ($this->item->program): ?>
        <p>
            <?php echo $this->item->program ?>
        </p>
    <?php endif; ?>
    <?php if (!empty($this->images)) :  ?>
        <div class="imagesSlider">
            <?php foreach($this->images as $image) : ?>
                <div><img src="<?php echo Juri::base() . $image->path ?>"/> </div>
            <?php endforeach; ?>
        </div>
    <?php endif;?>
    <?php if ($this->item->lat && $this->item->lng): ?>
        <style>
            #booking-map {
                height: 400px;
                width: 100%;
            }
        </style>
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
    <div class="author-inforow mb-40">
        <figure><img src="/joomla/angles/media/k2/users/1.jpg" alt="Super User"></figure>
                                
        <div class="author-infobox">
            <h6>Author : <a rel="author" href="/joomla/angles/index.php/blog/blog-detail/itemlist/user/409-superuser">Super User</a></h6>
          <p></p><p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p><p></p>
        </div><!--/.author-infobox-->
    </div>

</div>
<div class="col-xs-12 col-sm-4 col-md-4">  
    <div id="overview"></div>
    <div id="errors"></div>
    <div id="booking"></div>
    <ul class="taglist">
        <li><a href="#" id="cancel-step"><?php echo JText::_('COM_BOOKING_PREVIOUS') ?></a></li>
        <li><a href="#" id="save-step"><?php echo JText::_('COM_BOOKING_NEXT') ?></a></li>
    </ul>
</div>

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
