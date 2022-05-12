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

use arkontrackingorder\TrackingOrder;

if (!defined('_PS_VERSION_')) {
    exit;
}

class ArkonTrackingOrder extends Module
{

    public function __construct()
    {
        $this->name = 'arkontrackingorder';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Arkonsoft';
        $this->author_uri = 'https://arkonsoft.pl/';
        $this->need_instance = 1;
        $this->bootstrap = 1;

        parent::__construct();

        $this->displayName = $this->l('Arkon Tracking Order');
        $this->description = $this->l('Module for tracking order.');
        $this->confirmUninstall = $this->l('Are you sure? All data will be lost!');
        $this->ps_versions_compliancy = ['min' => '1.6', 'max' => _PS_VERSION_];
        $this->dependencies = array();

        $this->adminController = 'AdminArkonTrackingOrderSettings';

        require_once $this->getLocalPath() . '/classes/TrackingOrder.php';
    }

    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        return (parent::install()
            && $this->installTab()
            && TrackingOrder::install()
            && $this->registerHook('actionFrontControllerSetMedia')
        );
    }

    public function uninstall()
    {
        return (parent::uninstall()
            && $this->uninstallTab()
            && TrackingOrder::uninstall()
        );
    }

    public function installTab()
    {
        $tab = new Tab();
        $tab->id_parent = (int)Tab::getIdFromClassName('AdminParentThemes');
        $tab->name = [];
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = $this->displayName;
        }
        $tab->class_name = $this->adminController;
        $tab->module = $this->name;
        $tab->active = 1;
        return $tab->add();
    }

    public function uninstallTab()
    {
        $id_tab = (int)Tab::getIdFromClassName($this->adminController);
        $tab = new Tab((int)$id_tab);
        return $tab->delete();
    }
}
