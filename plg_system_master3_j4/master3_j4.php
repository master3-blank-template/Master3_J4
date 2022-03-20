<?php

/*
 * @package     Joomla.Plugin
 * @subpackage  System.Master3_J4
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;

class plgSystemMaster3_J4 extends CMSPlugin
{
    public function onAfterInitialise()
    {
        $file = JPATH_LIBRARIES . '/src/Form/Field/Sflayouts.php';
        if (file_exists($file)) {
            \JLoader::register('Joomla\CMS\Form\Field\SflayoutsField', $file);
        }
    }
}
