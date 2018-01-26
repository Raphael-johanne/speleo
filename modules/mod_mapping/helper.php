<?php
/**
 * @package    aure
 * @subpackage mod_mapping
 * 
 */
class ModMappingHelper {
    /**
     * Retrieves the formules in the data base
     *
     * @param none
     * @access public
     */
    public static function getFormules() {
        // Obtain a database connection
        $db = JFactory::getDbo();

        // Retrieve the shout
        $query = $db->getQuery(true)
                    ->select('f.*')
                    ->from('#__formule f')
                    ->where('f.is_published = 1');

        // Prepare the query
        $db->setQuery((string) $query);

        // Return the result
        return $db->loadObjectList();
    }
}
