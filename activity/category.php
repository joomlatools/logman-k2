<?php
/**
 * @package     LOGman
 * @copyright   Copyright (C) 2011 - 2016 Timble CVBA. (http://www.timble.net)
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.joomlatools.com
 */

/**
 * Category/K2 Activity Entity
 *
 * @author  Arunas Mazeika <https://github.com/amazeika>
 * @package Joomlatools\Plugin\LOGman
 */
class PlgLogmanK2ActivityCategory extends ComLogmanModelEntityActivity
{
    protected function _initialize(KObjectConfig $config)
    {
        $config->append(array(
            'object_table' => 'k2_categories',
            'format'       => '{actor} {action} {object.subtype} {object.type} title {object}'
        ));
        parent::_initialize($config);
    }

    protected function _objectConfig(KObjectConfig $config)
    {
        $config->append(array(
            'subtype' => array('object' => true, 'objectName' => 'K2'),
            'url'     => array('admin' => 'option=com_k2&view=category&cid=' . $this->row)
        ));

        parent::_objectConfig($config);
    }
}