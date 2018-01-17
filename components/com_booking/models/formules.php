<?php
/**
 * @package     racol
 * @subpackage  com_booking
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */


// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Formules Model
 *
 * @since  0.0.1
 */
class BookingModelFormules extends BookingFormule
{
    /**
     *
     * @return mixed
     *
     * @since version
     */
	public function getFormules()
	{
        $db         = $this->getDbo();
        $query      = $db->getQuery(true);
        $language   = JFactory::getLanguage();

        list($selects, $lefts) = BookingHelperLocalized::localized(
            parent::NAME_ATTRIBUTE,
            parent::ENTITY_TYPE,
            $language->getTag()
        );

        $selects[] = 'main.*';

        $query->select($selects);
        $query->from('#__formule main')
            ->where('main.is_published = 1')
            ->order ('main.order DESC');

        foreach ($lefts as $left) {
            $query->join('LEFT', $left);
        }

        $db->setQuery((string) $query);
        return $db->loadObjectList();
	}
}
