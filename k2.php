<?php
/**
 * @package     LOGman
 * @copyright   Copyright (C) 2011 - 2016 Timble CVBA. (http://www.timble.net)
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.joomlatools.com
 */

/**
 * K2 LOGman Plugin.
 *
 * @author  Arunas Mazeika <https://github.com/amazeika>
 * @package Joomlatools\Plugin\LOGman
 */
class PlgLogmanK2 extends ComLogmanPluginJoomla
{
    protected function _getItemObjectData($data, $event)
    {
        return array('id' => $data->id, 'name' => $data->title);
    }

    protected function _getCategoryObjectData($data, $event)
    {
        return array('id' => $data->id, 'name' => $data->name);
    }

    public function onFinderAfterSave($context, $row, $isNew)
    {
        // Item controller triggers both content and finder after save events. Only one should go through.
        if ($context != 'com_k2.item') {
            $this->onContentAfterSave($context, $row, $isNew); // Forward event to the content event handler.
        }
    }

    public function onFinderAfterDelete($context, $row)
    {
        // Forward event to the content event handler.
        $this->onContentAfterDelete($context, $row);
    }

    public function onFinderChangeState($context, $cid, $state)
    {
        // Forward event to the content event handler.
        $this->onContentChangeState($context, $cid, $state);
    }

    protected function _getItems($ids, KObjectConfig $config)
    {
        $config->type   = 'K2' . $config->type;
        $config->prefix = 'Table';

        return parent::_getItems($ids, $config);
    }
}