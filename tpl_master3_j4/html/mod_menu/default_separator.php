<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\Registry\Registry;

$moduleParams = new Registry($module->params);

if ($item->level > 1) {
    echo strpos($class_sfx, 'uk-nav-') === false && strpos($module->position, 'navbar') === false
        && strpos($moduleParams->get('layout'), ':subnav') === false
        ? '<hr class="uk-margin-small-top uk-margin-small-bottom">' : '';
    return;
}

$title      = $item->anchor_title ? ' title="' . $item->anchor_title . '"' : '';
$anchor_css = $item->anchor_css ? ' class="' . $item->anchor_css . '"' : '';
$linktype   = $item->title;

if ($item->menu_icon) {
    if ($itemParams->get('menu_text', 1)) {
        $linktype = '<span data-uk-icon="icon:' . $item->menu_icon . '" aria-hidden="true"></span><span>' . $item->title . '</span>';
    } else {
        $linktype = '<span data-uk-icon="icon:' . $item->menu_icon . '" aria-hidden="true"></span><span class="uk-hidden">' . $item->title . '</span>';
    }
} elseif ($item->menu_image) {
    $image_attributes = [];

    if ($item->menu_image_css) {
        $image_attributes['class'] = $item->menu_image_css;
    }

    $linktype = HTMLHelper::_('image', $item->menu_image, $item->title, $image_attributes);

    if ($itemParams->get('menu_text', 1)) {
        $linktype .= '<span class="image-title">' . $item->title . '</span>';
    }
}
if ($item->parent && strpos($moduleParams->get('layout'), ':subnav') !== false) {
    $linktype .= '<span data-uk-icon="icon:triangle-down"></span>';
}

?>
<a <?php echo $anchor_css; ?> <?php echo $title; ?>><?php echo $linktype; ?></a>
