<?php

/*
 * @package     Joomla.Plugin
 * @subpackage  System.Master3_J4
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;

class plgSystemMaster3_j4InstallerScript
{
    public function postflight($type, $parent)
    {
        $plugin          = new stdClass();
        $plugin->type    = 'plugin';
        $plugin->element = $parent->getElement();
        $plugin->folder  = (string) $parent->getParent()->manifest->attributes()['group'];
        $plugin->enabled = 1;

        Factory::getDbo()->updateObject('#__extensions', $plugin, ['type', 'element', 'folder']);
    }
}
