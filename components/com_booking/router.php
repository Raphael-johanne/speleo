<?php
/**
 * @package     racol
 * @subpackage  com_booking
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Routing class from com_booking
 *
 * @since  3.3
 */
class BookingRouter extends JComponentRouterBase
{
	/**
	 * Build the route for the com_booking component
	 *
	 * @param   array  &$query  An array of URL arguments
	 *
	 * @return  array  The URL arguments to use to assemble the subsequent URL.
	 *
	 * @since   3.3
	 */
	public function build(&$query) {
		$segments = [];

		if (isset($query['view'])) {
			$segments[] = $query['view'];
			unset($query['view']);
		}

		if (isset($query['id'])) {
			$segments[] = $query['id'];
			unset($query['id']);
		}

		if (isset($query['slug'])) {
			$segments[] = $query['slug'];
			unset($query['slug']);
		}

		return $segments;
	}

	/**
	 * Parse the segments of a URL.
	 *
	 * @param   array  &$segments  The segments of the URL to parse.
	 *
	 * @return  array  The URL attributes to be used by the application.
	 *
	 * @since   3.3
	 */
	public function parse(&$segments) {
		$vars = [];

		$vars['view'] 	= $segments[0];
		$vars['id'] 	= $segments[1];
		$vars['slug'] 	= $segments[2];

		return $vars;
	}
}

function bookingBuildRoute(&$query) {
	$router = new BookingRouter;

	return $router->build($query);
}

function bookingParseRoute($segments) {
	$router = new BookingRouter;

	return $router->parse($segments);
}
