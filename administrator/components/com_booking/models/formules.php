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
 * List Model
 *
 * @since  0.0.1
 */
class BookingModelFormules extends JModelList
{
    /**
     *
     * @return mixed
     *
     * @since version
     */
	protected function getListQuery()
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('f.*')
                ->from($db->quoteName('#__formule', 'f'));

		return $query;
	}

	/**
     * @param int $id
     *
     * @return bool
     *
     * @since version
     */
	public function canDelete($id) {
		$db    = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('fd.date');
        $query->from('#__formule_date fd')
        ->join('INNER', $db->quoteName('#__formule', 'f') . ' ON (' . $db->quoteName('f.id') . ' = ' . $db->quoteName('fd.formule_id') . ')')
            ->where('fd.formule_id = ' . (int) $id)
            ->where('fd.place_remaining < f.max_person_allowed');
        $db->setQuery((string) $query);
        return $db->loadColumn() ? false : true;
	}

	/**
     * @param int $id
     *
     * @return void
     *
     * @since version
     */
	public function delete($id) {
		$db         = JFactory::getDbo();
        $query      = $db->getQuery(true);

        $query->delete($db->quoteName('#__formule_period'));
        $query->where($db->quoteName('formule_id') . ' = ' . (int) $id);
        $db->setQuery($query);
        $db->query();

        $query      = $db->getQuery(true);

        $query->delete($db->quoteName('#__formule_date'));
        $query->where($db->quoteName('formule_id') . ' = ' . (int) $id);
        $db->setQuery($query);
        $db->query();

        $query      = $db->getQuery(true);

        $query->delete($db->quoteName('#__booking_localized'));
        $query->where($db->quoteName('entity_id') . ' = ' . (int) $id);
        $query->where($db->quoteName('entity_type') . ' = ' .  $db->quote(BookingFormule::ENTITY_TYPE));
        $db->setQuery($query);
        $db->query();

        $query      = $db->getQuery(true);

        $query->delete($db->quoteName('#__booking'));
        $query->where($db->quoteName('formule_id') . ' = ' . (int) $id);
        $db->setQuery($query);
        $db->query();

        $query      = $db->getQuery(true);

        $query->delete($db->quoteName('#__formule'));
        $query->where($db->quoteName('id') . ' = ' . (int) $id);
        $db->setQuery($query);
        $db->query();
	}
}
