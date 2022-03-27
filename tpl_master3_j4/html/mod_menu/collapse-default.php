<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   (C) 2021 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\Registry\Registry;

$moduleParams = new Registry($module->params);

if (strpos($class_sfx, 'uk-nav-parent-icon') === false) {
    $class_sfx .= ' uk-nav-parent-icon';
}

require __DIR__ . '/nav.php';
