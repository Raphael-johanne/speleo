<?php
/**
 * @package     racol
 * @subpackage  com_booking
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */

class BookingFormule extends JModelItem
{
    const NAME_ATTRIBUTE            = 'name';
    const PROGRAM_ATTRIBUTE         = 'program';
    const DESCRIPTION_ATTRIBUTE     = 'description';
    const ENTITY_TYPE               = 'formule';

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
    public function getTable($type = 'Formule', $prefix = 'BookingTable', $config = array())
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
            self::NAME_ATTRIBUTE,
            self::PROGRAM_ATTRIBUTE,
            self::DESCRIPTION_ATTRIBUTE
        ];
    }
}
