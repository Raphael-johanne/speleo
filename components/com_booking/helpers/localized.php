<?php
/**
 * @package     racol
 * @subpackage  com_booking
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Content Component Encrypt Helper.
 *
 * @since  1.5
 */
class BookingHelperLocalized
{
    /**
     * @param array $attributes
     * @param $entityType
     * @param null $language
     *
     * @return array
     *
     * @since version
     */
    public static function localized($attributes, $entityType, $language)
    {
        if (!is_array($attributes)) {
            $attributes = [$attributes];
        }

        $selects = $lefts = [];

        $i = 0;
        foreach ($attributes as $attribute) {
            $selects[] = sprintf('l%d.value as %s',
                $i,
                $attribute,
                $i
            );
            $lefts[] =  sprintf("speleo_booking_localized as l%d ON l%d.entity_type = '%s' AND l%d.entity_id = main.id AND l%d.code = '%s' AND l%d.language = '%s'",
                $i,
                $i,
                $entityType,
                $i,
                $i,
                $attribute,
                $i,
                $language
            );
            $i++;
        }

        return [
            $selects,
            $lefts
        ];
    }
}
