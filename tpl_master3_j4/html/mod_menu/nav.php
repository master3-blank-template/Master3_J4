<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

$id = '';

if ($tagId = $params->get('tag_id', '')) {
    $id = 'id="' . $tagId . '" ';
}

$attrsMenu = strpos($class_sfx, 'uk-nav-') !== false ? ' data-uk-nav' : '';

?>
<ul <?php echo $id; ?>class="mod-menu uk-nav <?php echo $class_sfx; ?>"<?php echo $attrsMenu; ?>>
    <?php foreach ($list as $i => &$item) {
        $itemParams = $item->getParams();
        $class      = 'item-' . $item->id;

        if ($item->id == $default_id) {
            $class .= ' uk-default';
        }

        if ($item->id == $active_id || ($item->type === 'alias' && $itemParams->get('aliasoptions') == $active_id)) {
            $class .= ' uk-active';
        }

        if (in_array($item->id, $path)) {
            $class .= ' uk-active';
        } elseif ($item->type === 'alias') {
            $aliasToId = $itemParams->get('aliasoptions');
            if (count($path) > 0 && $aliasToId == $path[count($path) - 1] || in_array($aliasToId, $path)) {
                $class .= ' uk-active';
            }
        }

        if ($item->parent || $item->deeper) {
            $class .= ' uk-parent';
        }

        if ($item->type === 'separator') {
            $class .= ' uk-nav-divider';
        }

        if ($item->type == 'heading') {
            $class .= ' uk-nav-header';
        }

        echo '<li class="' . $class . '">';

        switch ($item->type):
            case 'separator':
            case 'component':
            case 'heading':
            case 'url':
                require ModuleHelper::getLayoutPath('mod_menu', 'default_' . $item->type);
                break;

            default:
                require ModuleHelper::getLayoutPath('mod_menu', 'default_url');
                break;
        endswitch;

        if ($item->deeper) {
            echo '<ul class="uk-nav-sub">';
        } elseif ($item->shallower) {
            echo '</li>';
            echo str_repeat('</ul></li>', $item->level_diff);
        } else {
            echo '</li>';
        }
    }
    ?>
</ul>
