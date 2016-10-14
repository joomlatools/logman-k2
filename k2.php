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
        $this->onContentAfterDelete($context, $row); // Forward event to the content event handler.
    }

    public function onFinderChangeState($context, $cid, $state)
    {
        $this->onContentChangeState($context, $cid, $state); // Forward event to the content event handler.
    }

    protected function _getItems($ids, KObjectConfig $config)
    {
        $config->type   = 'K2' . $config->type;
        $config->prefix = 'Table';

        return parent::_getItems($ids, $config);
    }

    public function onContentChangeState($context, $pks, $state)
    {
        if (in_array($context, $this->_contexts))
        {
            $parts = explode('.', $context);

            $table = sprintf('k2_%s', KStringInflector::pluralize($parts[1]));

            $adapter = $this->getObject('lib:database.adapter.mysqli');

            $query = $this->getObject('lib:database.query.select')
                          ->table($table)
                          ->columns('trash')
                          ->where('id IN :id')
                          ->bind(array('id' => $pks));

            if ($adapter->select($query, KDatabase::FETCH_FIELD) == 1) {
                $state = -2; // Set state as trash
            }
        }

        parent::onContentChangeState($context, $pks, $state);
    }
}