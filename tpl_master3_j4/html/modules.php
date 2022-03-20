<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.Master3_J4
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

\defined('_JEXEC') or die;

function modChrome_master3($module, &$params, &$attribs)
{
    $moduleTag = 'div';
    if ($module->module === 'mod_menu') {
        $moduleTag = 'nav';
    }

    $moduleClass = [];
    $moduleClass[] = 'tm-position-' . $module->position;
    $moduleClass[] = 'tm-modid-' . $module->id;
    $moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx', ''));
    if ($moduleclass_sfx) {
        $moduleClass[] = 'tm-modclass-' . $moduleclass_sfx;
    }
    $moduleClass = trim(implode(' ', $moduleClass));

    $titleTag = htmlspecialchars($params->get('header_tag', 'h3'));
    $titleClass = htmlspecialchars($params->get('header_class', ''), ENT_COMPAT, 'UTF-8');
    $titleClass = $titleClass ? ' class="' . $titleClass . '"' : '';

    if ($module->content) {
        echo '<div><' . $moduleTag . ' class="' . trim($moduleClass) . '">';

        if ($module->showtitle) {
            echo '<' . $titleTag . $titleClass . '>' . $module->title . '</' . $titleTag . '>';
        }

        echo $module->content;

        echo '</' . $moduleTag . '></div>';
    }
}

function modChrome_empty($module, &$params, &$attribs)
{
    echo str_replace(
        ["<div >\r\n    ", "<div >\n    ", "</div>\r\n", "</div>\n", "</div>\r"],
        ['<div>', '<div>', '</div>', '</div>', '</div>'],
        $module->content
    );
}
