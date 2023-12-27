<?php
/**
*  @author    sHKamil - Kamil Hałasa
*  @copyright sHKamil - Kamil Hałasa
*  @license   .l
*/

namespace PrestaShop\Module\Clientcomments\Sql;

class ClientcommentsModuleModel extends ObjectModel
{
    public $id_yourmodule_data;
    public $name;
    public $message;

    public static $definition = [
        'table' => 'clientcomments',
        'primary' => 'id_clientcomments',
        'fields' => [
            'name' => ['type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true],
            'message' => ['type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true],
        ],
    ];

    public static function getAllData()
    {
        $sql = 'SELECT * FROM `' . _DB_PREFIX_ . 'clientcomments`';
        return Db::getInstance()->executeS($sql);
    }

    // Add other methods for CRUD operations as needed
}