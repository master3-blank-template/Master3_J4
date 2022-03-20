<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.Master3_J4
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

\defined('_JEXEC') or die;

include_once(__DIR__ . '/config.php');

$files = [
    realpath(__DIR__ . '/layouts/template.error.php'),
    realpath(__DIR__ . '/layouts/template.error-original.php')
];

foreach ($files as $file) {
    if (file_exists($file)) {
        include($file);
        break;
    }
}
