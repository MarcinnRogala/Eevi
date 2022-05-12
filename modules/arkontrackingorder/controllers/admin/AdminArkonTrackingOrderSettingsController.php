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

class AdminArkonCustomBlocksSettingsController extends ModuleAdminController
{
    public function __construct()
    {
        $this->context = Context::getContext();
        $this->context->controller = $this;
        $this->bootstrap = true;
        parent::__construct();

        $this->table = TrackingOrder::$definition['table'];
        $this->identifier = TrackingOrder::$definition['primary'];
        $this->className = TrackingOrder::class;
        $this->lang = true;

        $this->prepareList();
        $this->prepareForm();
    }

    public function prepareList()
    {
        $this->_defaultOrderBy = 'position';
        $this->_defaultOrderWay = 'ASC';
        $this->allow_export = true;
        $this->position_identifier = $this->identifier;

        $this->fields_list = [
            TrackingOrder::$definition['primary'] => [
                'title' => $this->module->l('ID'),
            ],
            'title' => [
                'title' => $this->module->l('Title'),
                'lang' => true
            ],
            'description' => [
                'title' => $this->module->l('Description'),
                'lang' => true
            ],
            'link' => [
                'title' => $this->module->l('Link'),
                'lang' => true
            ],
            'position' => [
                'title' => $this->module->l('Position'),
                'position' => 'position'
            ],
            'active' => [
                'title' => $this->module->l('Status'),
                'active' => 'status'
            ]
        ];

        $this->addRowAction('edit');
        $this->addRowAction('delete');

        $this->bulk_actions = [
            'delete' => [
                'text' => $this->module->l('Delete selected'),
                'confirm' => $this->module->l('Would you like to delete selected items?'),
            ],
        ];
    }

    public function prepareForm()
    {
        $this->fields_form = [
            'legend' => [
                'title' => $this->module->displayName,
                'icon' => 'icon-list-ul'
            ],
            'input' => [
                [
                    'name' => 'title',
                    'label' => $this->module->l('Title'),
                    'type' => 'text',
                    'lang' => true,
                    'required' => true
                ],
                [
                    'name' => 'description',
                    'label' => $this->module->l('Description'),
                    'type' => 'textarea',
                    'class' => 'rte',
                    'autoload_rte' => true,
                    'lang' => true
                ],
                [
                    'name' => 'link',
                    'label' => $this->module->l('Link'),
                    'type' => 'text',
                    'lang' => true
                ],
                [
                    'label' => $this->module->l('Active'),
                    'type' => 'switch',
                    'name' => 'active',
                    'required' => true,
                    'values' => [
                        [
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->module->l('On'),
                        ],
                        [
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->module->l('Off'),
                        ],
                    ],
                ],
            ],
            'submit' => [
                'title' => $this->module->l('Save'),
            ],

        ];
    }

    public function ajaxProcessUpdatePositions()
    {
        if ($this->access('edit')) {
            $way = (int) Tools::getValue('way');
            $id_item = (int) Tools::getValue('id');
            $positions = Tools::getValue(TrackingOrder::getClassNameInSnakeCase());

            $new_positions = [];
            foreach ($positions as $v) {
                if (!empty($v)) {
                    $new_positions[] = $v;
                }
            }

            foreach ($new_positions as $position => $value) {
                $pos = explode('_', $value);

                if (isset($pos[2]) && (int) $pos[2] === $id_item) {
                    if ($item = new TrackingOrder((int) $pos[2])) {
                        if (isset($position) && $item->updatePosition($way, $position, $id_item)) {
                            echo 'ok position ' . (int) $position . ' for item ' . (int) $pos[1] . '\r\n';
                        } else {
                            echo '{
                                "hasError" : true, 
                                "errors" : 
                                "Can not update item ' . (int) $id_item . ' to position ' . (int) $position . ' "
                            }';
                        }
                    } else {
                        echo '{
                            "hasError" : true, 
                            "errors" : 
                            "This item (' . (int) $id_item . ') can t be loaded"
                        }';
                    }

                    break;
                }
            }
        }
    }

    public function postProcess()
    {
        parent::postProcess();

        $id = Tools::getValue(TrackingOrder::$definition['primary']);
    }
}
