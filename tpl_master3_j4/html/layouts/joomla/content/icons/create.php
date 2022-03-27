<?php

/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   (C) 2016 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @deprecated  5.0 without replacement
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

$jsIcons = Factory::getContainer()
    ->get(Joomla\CMS\Application\SiteApplication::class)
    ->getTemplate(true)
    ->params
    ->get('jsIcons', 'none') != 'none';

$params = $displayData['params'];


if ($jsIcons) {
    echo '<span id="' . $aria_described . '" data-uk-icon="icon:file-text" role="tooltip" aria-hidden="true" data-uk-tooltip="' . Text::_('JNEW') . '"></span>';
} else {
    echo '<span id="' . $aria_described . '" aria-hidden="true">' . Text::_('JNEW') . '</span>';
}
