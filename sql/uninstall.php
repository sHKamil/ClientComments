<?php
/**
*  @author    sHKamil - Kamil Hałasa
*  @copyright sHKamil - Kamil Hałasa
*  @license   .l
*/

/**
 * In some cases you should not drop the tables.
 * Maybe the merchant will just try to reset the module
 * but does not want to loose all of the data associated to the module.
 */
$sql = [];
$sql[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "clientcomments`";

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
