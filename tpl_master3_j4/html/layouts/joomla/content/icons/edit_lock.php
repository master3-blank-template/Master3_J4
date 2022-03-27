<?php

/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   (C) 2016 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

$jsIcons = Factory::getContainer()
    ->get(Joomla\CMS\Application\SiteApplication::class)
    ->getTemplate(true)
    ->params
    ->get('jsIcons', 'none') != 'none';

if (isset($displayData['ariaDescribed'])) {
    $aria_described = $displayData['ariaDescribed'];
} elseif (isset($displayData['article'])) {
    $article        = $displayData['article'];
    $aria_described = 'editarticle-' . (int) $article->id;
} elseif (isset($displayData['contact'])) {
    $contact        = $displayData['contact'];
    $aria_described = 'editcontact-' . (int) $contact->id;
}

$tooltip = $displayData['tooltip'];

if ($jsIcons) {
    echo '<span id="' . $aria_described . '" data-uk-icon="icon:lock" role="tooltip" aria-hidden="true" data-uk-tooltip="' . $tooltip . '"></span>';
} else {
    echo '<span id="' . $aria_described . '" role="tooltip" aria-hidden="true" data-tooltip="' . $tooltip . '">' . Text::_('JLIB_HTML_CHECKED_OUT') . '</span>';
}
