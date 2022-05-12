<?php
/**
* NOTICE OF LICENSE
*
* This file is licensed under the Software License Agreement.
*
* With the purchase or the installation of the software in your application
* you accept the licence agreement.
*
* You must not modify, adapt or create derivative works of this source code
*
* @author Arkonsoft
* @copyright 2017-2022 Arkonsoft
* @license https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
*/

use ArkonTrackingOrder;
use Db;
use ObjectModel;
use PrestaShopCollection;
use Tools;

if (!defined('_PS_VERSION_')) {
    exit;
}

class TrackingOrder extends ObjectModel
{
    public $title;
    public $description;
    public $link;
    public $image;
    public $position;
    public $active;

    public static $definition = [
        'table' => 'arkon_tracking_order',
        'primary' => 'id_custom_block',
        'multilang' => true,
        'fields' => [
            'title' => [
                'type' => self::TYPE_STRING,
                'lang' => true,
                'validate' => 'isCleanHtml',
                'size' => 255,
                'required' => true
            ],
            'description' => [
                'type' => self::TYPE_HTML,
                'lang' => true,
                'validate' => 'isCleanHtml',
                'size' => 2000
            ],
            'link' => [
                'type' => self::TYPE_STRING,
                'lang' => true,
                'validate' => 'isUrl',
                'required' => false,
                'size' => 255
            ],
            'position' => [
                'type' => self::TYPE_INT,
                'validate' => 'isunsignedInt',
                'required' => false
            ],
            'active' => [
                'type' => self::TYPE_BOOL,
                'validate' => 'isBool',
                'required' => true
            ]
        ]
    ];

    public function __construct($id = null, $id_lang = null, $id_shop = null, $translator = null)
    {
        parent::__construct($id, $id_lang, $id_shop, $translator);
    }

    public static function install(): bool
    {
        return (self::createTable()
            && self::createLangTable()
        );
    }

    public static function uninstall(): bool
    {
        return (self::dropTable()
            && self::dropLangTable()
        );
    }

    public static function createTable(): bool
    {
        $sql = '
            CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . self::$definition['table'] . '` (
                `' . self::$definition['primary'] . '` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `position` int(11),
                `active` int(1),
                PRIMARY KEY (`' . self::$definition['primary'] . '`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
        ';

        return Db::getInstance()->execute($sql);
    }

    public static function createLangTable(): bool
    {
        $sql = '
            CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . self::$definition['table'] . '_lang` (
                `' . self::$definition['primary'] . '` int(11) NOT NULL,
                `id_lang` int(10) unsigned NOT NULL,
                `title` varchar(255) NOT NULL,
                `description` varchar(2048),
                `link` varchar(255),
                PRIMARY KEY (`' . self::$definition['primary'] . '`, `id_lang`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
        ';

        return Db::getInstance()->execute($sql);
    }

    public static function dropTable()
    {
        $sql = 'DROP TABLE IF EXISTS ' . _DB_PREFIX_ . self::$definition['table'] . ';';

        return Db::getInstance()->execute($sql);
    }

    public static function dropLangTable()
    {
        $sql = 'DROP TABLE IF EXISTS ' . _DB_PREFIX_ . self::$definition['table'] . '_lang;';

        return Db::getInstance()->execute($sql);
    }

    public function updatePosition($way, $position, $id = null)
    {
        if (!$res = Db::getInstance()->executeS(
            '
			SELECT `position`, `' . self::$definition['primary'] . '`
			FROM `' . _DB_PREFIX_ . self::$definition['table'] . '`
			WHERE `' . self::$definition['primary'] . '` = ' . (int) ($id ? $id : $this->id) . '
			ORDER BY `position` ASC'
        )) {
            return false;
        }

        foreach ($res as $item) {
            if ((int) $item[self::$definition['primary']] == (int) $this->id) {
                $moved_item = $item;
            }
        }

        if (!isset($moved_item) || !isset($position)) {
            return false;
        }

        return Db::getInstance()->execute('
			UPDATE `' . _DB_PREFIX_ . self::$definition['table'] . '`
			SET `position`= `position` ' . ($way ? '- 1' : '+ 1') . '
			WHERE `position`
			' . ($way
                ? '> ' . (int) $moved_item['position'] . ' AND `position` <= ' . (int) $position
                : '< ' . (int) $moved_item['position'] . ' AND `position` >= ' . (int) $position))
        && Db::getInstance()->execute('
			UPDATE `' . _DB_PREFIX_ . self::$definition['table'] . '`
			SET `position` = ' . (int) $position . '
			WHERE `' . self::$definition['primary'] . '`=' . (int) $moved_item[self::$definition['primary']]);
    }

    public static function getClassNameInSnakeCase()
    {
        $path = explode('\\', __CLASS__);
        $className = array_pop($path);

        return Tools::strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $className));
    }

    public function getAll($id_lang = null)
    {
        $collection = new PrestaShopCollection(self::class, $id_lang);
        return $collection
            ->where('active', '=', 1)
            ->getAll();
    }
}
