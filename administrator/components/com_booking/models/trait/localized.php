<?php
/**
 * @package     racol
 * @subpackage  com_booking
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

trait localized {

    /**
     * @param $id
     * @param $entityType
     * @param $attributes
     *
     *
     * @since version
     */
	public function saveLocalized($id, $entityType, $attributes)
    {
        $attributes = JRequest::getVar('attributes', []);
        $columns    = ['entity_type', 'entity_id', 'language', 'code', 'value'];

        $db         = JFactory::getDbo();
        $query      = $db->getQuery(true);
        $query->delete($db->quoteName('#__booking_localized'));
        $query->where($db->quoteName('entity_id') . ' = ' . (int) $id);
        $query->where($db->quoteName('entity_type') . ' = ' . $db->quote($entityType));
        
        $db->setQuery($query);
        $db->query();

        foreach ($attributes as $locale => $fields) {
            $query = $db->getQuery(true);
            $values = [];
            foreach ($fields as $code => $value) {
                $values[] = sprintf("'%s', %d, '%s', '%s', '%s'",
                    $entityType,
                    $id,
                    $locale,
                    $code,
                    $value
                    );
            }

            $query->insert($db->quoteName('#__booking_localized'));
            $query->columns($columns);
            $query->values($values);
            $db->setQuery($query);
            $db->query();
        }
    }
}
