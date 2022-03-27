<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.Master3_J4
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

\defined('_JEXEC') or die;

$module  = $displayData['module'];

echo str_replace(
    ["<div >\r\n    ", "<div >\n    ", "</div>\r\n", "</div>\n", "</div>\r"],
    ['<div>', '<div>', '</div>', '</div>', '</div>'],
    $module->content
);
