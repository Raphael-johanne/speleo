DROP TABLE IF EXISTS `speleo_booking`;
DROP TABLE IF EXISTS `speleo_formule`;
DROP TABLE IF EXISTS `speleo_period`;
DROP TABLE IF EXISTS `speleo_formule_period`;
DROP TABLE IF EXISTS `speleo_formule_localized`;
DELETE FROM speleo_extensions WHERE element = "com_booking";
