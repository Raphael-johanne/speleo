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
 *  Controller
 *
 * @package     racol
 * @subpackage  com_booking
 * @since       0.0.9
 */
class BookingControllerFormule extends JControllerForm
{
    /**
     * @param $model
     * @param $validData
     *
     *
     * @since version
     */
    protected function postSaveHook($model, $validData) {
        $item       = $model->getItem();
        $itemId     = $item->get('id');
        $values     = [];
        $db         = JFactory::getDbo();
        $columns    = ['formule_id','period_id'];

        $query = $db->getQuery(true);

        $query->delete($db->quoteName('#__formule_period'));
        $query->where($db->quoteName('formule_id') . ' = ' . (int) $itemId);

        $db->setQuery($query);
        $db->query();

        $query = $db->getQuery(true);

        foreach ($validData['period_ids'] as $periodId) {
            $values[] = (int) $itemId .', '.(int) $periodId;
        }

        $query->insert($db->quoteName('#__formule_period'));
        $query->columns($columns);

        $query->values($values);

        $db->setQuery($query);
        $db->query();
    }
}
