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
 * Formule Model
 *
 * @since  0.0.1
 */
class BookingModelFormule extends BookingFormule
{
    /**
     * @param $id
     *
     * @return mixed
     *
     * @since version
     */
    public function getFormule($id) {
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
        $query->from('#__formule main')
            ->where('main.is_published = 1')
            ->where(
                sprintf('main.id = %d',
                   (int) $id
                )
            )
            ->order ('main.order DESC');

        foreach ($lefts as $left) {
            $query->join('LEFT', $left);
        }

        $db->setQuery((string) $query);
        return $db->loadObject();
    }

    /**
     * @param $id
     *
     * @return mixed
     *
     * @since version
     */
    public function getImages($id) {
        $db    = $this->getDbo();
        $query = $db->getQuery(true);

        $query->select(['code', 'path']);
        $query->from('#__formule_image')
            ->where(
                sprintf('formule_id = %d',
                   (int) $id
                )
            );

        $db->setQuery((string) $query);
        return $db->loadObjectList();
    }
}
