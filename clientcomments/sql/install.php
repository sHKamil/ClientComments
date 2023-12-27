<?php
/**
*  @author    sHKamil - Kamil Hałasa
*  @copyright sHKamil - Kamil Hałasa
*  @license   .l
*/
$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'clientcomments` (
    `id_clientcomments` int(11) NOT NULL AUTO_INCREMENT,
    `client_name` varchar(64) NOT NULL,
    `message` varchar(500) NOT NULL,
    PRIMARY KEY  (`id_clientcomments`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
