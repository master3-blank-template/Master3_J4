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

$article = $displayData['article'];
$tooltip = $displayData['tooltip'];
$nowDate = strtotime(Factory::getDate());

$icon = $article->state ? 'edit' : 'eye-slash';
$currentDate   = Factory::getDate()->format(Text::_('DATE_FORMAT_LC6'));
$isUnpublished = ($article->publish_up > $currentDate)
    || !is_null($article->publish_down) && ($article->publish_down < $currentDate);

if ($isUnpublished) {
    $icon = 'eye-slash';
}
$aria_described = 'editarticle-' . (int) $article->id;

if ($jsIcons) {
    echo '<span id="' . $aria_described . '" data-uk-icon="icon:file-edit" role="tooltip" aria-hidden="true" data-uk-tooltip="' . Text::_('JGLOBAL_EDIT') . '"></span>';
} else {
    echo '<span id="' . $aria_described . '" aria-hidden="true">' . Text::_('JGLOBAL_EDIT') . '</span>';
}
