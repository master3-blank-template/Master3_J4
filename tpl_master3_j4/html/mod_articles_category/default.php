<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 *
 * @copyright   (C) 2010 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Language\Text;

if (!$list) {
    return;
}

?>
<ul class="uk-nav mod-articlescategory category-module mod-list">
    <?php
    if ($grouped) {
        foreach ($list as $groupName => $items) {
        ?>
        <li>
            <div class="uk-h4 mod-articles-category-group"><?php echo Text::_($groupName); ?></div>
            <ul class="uk-nav-sub">
                <?php require ModuleHelper::getLayoutPath('mod_articles_category', $params->get('layout', 'default') . '_items'); ?>
            </ul>
        </li>
        <?php
        }
    } else {
        $items = $list;
        require ModuleHelper::getLayoutPath('mod_articles_category', $params->get('layout', 'default') . '_items');
    }
    ?>
</ul>
