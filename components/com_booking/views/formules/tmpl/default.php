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
<div class="section blog-section">
	<div class="blog-posts animated-row">
		<?php foreach ($this->items as $item):
		    $link = JRoute::_(BookingHelperRoute::getFormuleRoute($item->id, $item->name));
		    ?>
		    <div data-animate="fadeInUp" class="col col-sm-6 col-md-4 Leading animated fadeInUp">
		<div class="blog-box">
			<div class="blog-img-box">
				<div class="blog-img-box">
				<figure>
					<a href="<?php echo $link ?>">
						<img src="<?php echo $item->image ?>" alt="<?php echo strip_tags($item->name) ?>">
					</a>
				</figure>
				<!-- Item category name -->
				<span class="blog-category">
					<?php echo JText::_('Formule') ?>
				</span>
			</div>
			<div class="blog-info">
				<div class="blog-details">
					<!-- Item title -->
					<h3 class="post-title">		
						<a href="<?php echo $link?>">
			        		<?php echo strip_tags($item->name) ?>
			    		</a>								
					</h3>
					<p><?php echo substr(strip_tags($item->description), 0, 256) ?>&nbsp;...</p>
				</div><!--/.blog-details-->
						<div class="blog-bottom-row">
							<!-- Item Author -->
							<span class="posted-by">
								<i class="fa fa-user" aria-hidden="true"></i>
								<?php echo JText::sprintf('COM_BOOKING_PRICE', $item->price) ?>
							</span>
						</div><!--/.blog-bottom-row-->
					</div>
		    	</div>
			</div>
		</div>
		<?php endforeach ?>
	</div>
</div>
