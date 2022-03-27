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

$firstLevel = (int) $list[array_key_first($list)]->level;

?>
<ul <?php echo $id; ?>class="mod-menu uk-subnav <?php echo $class_sfx; ?>" data-uk-margin>
    <?php foreach ($list as $i => &$item) {
        $itemParams = $item->getParams();
        $class      = 'item-' . $item->id;

        if ($item->id == $default_id) {
            $class .= ' uk-default';
        }

        if ($item->id == $active_id || ($item->type === 'alias' && $itemParams->get('aliasoptions') == $active_id) || in_array($item->id, $path)) {
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
            if ((int) $item->level === $firstLevel) {
                echo '<div data-uk-dropdown="mode:click"><ul class="uk-nav uk-dropdown-nav">';
            } else {
                echo '<ul class="uk-nav-sub">';
            }
        } elseif ($item->shallower) {
            echo '</li>';

            $level_diff = (int) $item->level_diff - 1;

            if ($level_diff) {
                echo str_repeat('</ul></li>', $level_diff);
            }

            if (((int) $item->level - (int) $item->level_diff) === $firstLevel) {
                echo '</ul></div></li>';
            } else {
                echo '</ul></li>';
            }
        } else {
            echo '</li>';
        }
    }
    ?>
</ul>
