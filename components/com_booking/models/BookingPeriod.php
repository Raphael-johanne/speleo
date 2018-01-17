<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */

class BookingPeriod extends JModelItem
{
    const NAME_ATTRIBUTE            = 'name';
    const ENTITY_TYPE               = 'period';

	/**
	 * Method to get a table object, load it if necessary.
	 *
	 * @param   string  $type    The table name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JTable  A JTable object
	 *
	 * @since   1.6
	 */
	public function getTable($type = 'Period', $prefix = 'BookingTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

    /**
     *
     * @return array
     *
     * @since version
     */
    public static function getAttributes() {
        return [
            self::NAME_ATTRIBUTE
        ];
    }
}
