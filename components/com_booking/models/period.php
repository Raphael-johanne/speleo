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
use Joomla\Utilities\ArrayHelper;
/**
 * Period Model
 *
 * @since  0.0.1
 */
class BookingModelPeriod extends BookingPeriod
{
    /**
     * @param $id
     *
     * @return mixed
     *
     * @since version
     */
    public function getPeriod($id)
    {
        $db    = $this->getDbo();
        $query = $db->getQuery(true);
        $language = JFactory::getLanguage();

        list($selects, $lefts) = BookingHelperLocalized::localized(
            $this->getAttributes(),
            parent::ENTITY_TYPE,
            $language->getTag()
        );
        
        $selects[] = 'main.*';

        $query->select($selects);
        $query->from('#__period main')
            ->where(
                sprintf('main.id = %d',
                   (int) $id
                )
            );

        foreach ($lefts as $left) {
            $query->join('LEFT', $left);
        }

        $db->setQuery((string) $query);
        return $db->loadObject();
    }
}
