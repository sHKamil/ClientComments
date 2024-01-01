<?php
/**
*  @author    sHKamil - Kamil Hałasa
*  @copyright sHKamil - Kamil Hałasa
*  @license   .l
*/

namespace Prestashop\Module\Clientcomments\Classes;

class ClientcommentsModel extends \ObjectModel
{
    public static $definition = [
        'table' => 'clientcomments',
        'primary' => 'id_clientcomments',
        'fields' => [
            'name' => ['type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true],
            'message' => ['type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true],
            'active' => ['type' => self::TYPE_BOOL, 'required' => true],
        ],
    ];
    
    public static function getAllData() {
        $table = '`' . _DB_PREFIX_ . 'clientcomments`';
        $sql = 'SELECT * FROM ' . $table;
        return \Db::getInstance()->executeS($sql);
    }

    public static function getSelected() {
        $sql = 'SELECT * FROM `' . _DB_PREFIX_ . 'clientcomments` WHERE active = 1';
        return \Db::getInstance()->executeS($sql);
    }

    public static function saveComment($name, $message) {
        $db = \Db::getInstance();
        $data = [
            'client_name' => $name,
            'message' => $message
        ];
        return $db->insert('clientcomments', $data);
    }

    public static function setActive($id, $active) {
        $db = \Db::getInstance();
        return $db->update('clientcomments', [
            'active' => $active
        ], 'id_clientcomments = ' . $id, 1);
    }

    public static function deleteById($id) {
        $db = \Db::getInstance();
        return $db->delete('clientcomments', 'id_clientcomments = ' . $id);
    }
}
