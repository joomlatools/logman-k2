<?php
/**
 * @package     LOGman
 * @copyright   Copyright (C) 2011 - 2016 Timble CVBA. (http://www.timble.net)
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.joomlatools.com
 */

/**
 * Item/K2 Activity Entity
 *
 * @author  Arunas Mazeika <https://github.com/amazeika>
 * @package Joomlatools\Plugin\LOGman
 */
class PlgLogmanK2ActivityItem extends ComLogmanModelEntityActivity
{
    protected function _initialize(KObjectConfig $config)
    {
        if ($config->data->action == 'read') {
            $config->append(array('format' => '{actor} {action} {object.subtype} {object.type} {object}'));
        }

        $config->append(array(
            'object_table' => 'k2_items',
            'format'       => '{actor} {action} {object.subtype} {object.type} title {object}'
        ));

        parent::_initialize($config);
    }

    protected function _objectConfig(KObjectConfig $config)
    {
        $config->append(array(
            'subtype' => array('object' => true, 'objectName' => 'K2'),
        ));

        if ($this->getActivityVerb() == 'read')
        {
            $helper = $this->getObject('com://admin/logman.template.helper.impression');

            $url = $this->getObject('lib:http.url', array(
                'url' => $helper->route(
                    array('url' => $this->title))
            ));
        }
        else $url = 'option=com_k2&view=item&cid=' . $this->row;

        $config->append(array('url' => array('admin' => $url)));

        parent::_objectConfig($config);
    }
}