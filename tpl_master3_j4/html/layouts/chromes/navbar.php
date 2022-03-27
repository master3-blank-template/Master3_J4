<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.Master3_J4
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

\defined('_JEXEC') or die;

$module  = $displayData['module'];
$params  = $displayData['params'];

$moduleTag = $module->module === 'mod_menu' ? 'nav' : 'div';
$moduleClass = [];
$moduleClass[] = 'tm-position-' . $module->position;
$moduleClass[] = 'tm-modid-' . $module->id;
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx', ''), ENT_COMPAT, 'UTF-8');
if ($moduleclass_sfx) {
    $moduleClass[] = 'tm-modclass-' . $moduleclass_sfx;
}
$moduleClass = trim(implode(' ', $moduleClass));

if ($module->content) {
    echo '<' . $moduleTag . ' class="' . trim($moduleClass) . '">';

    echo $module->content;

    echo '</' . $moduleTag . '>';
}
