<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 *
 * @copyright   (C) 2020 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

?>
<?php foreach ($items as $item) { ?>
    <li>
        <?php
        if ($params->get('link_titles') == 1) {
            $attributes = ['class' => 'mod-articles-category-title ' . $item->active];
            $link = htmlspecialchars($item->link, ENT_COMPAT, 'UTF-8', false);
            $title = htmlspecialchars($item->title, ENT_COMPAT, 'UTF-8', false);
            echo HTMLHelper::_('link', $link, $title, $attributes);
        } else {
            echo $item->title;
        }
        ?>

        <?php if ($item->displayHits) { ?>
            <span class="uk-badge mod-articles-category-hits"><?php echo $item->displayHits; ?></span>
        <?php } ?>

        <?php if ($params->get('show_author')) { ?>
            <span class="mod-articles-category-writtenby"><?php echo $item->displayAuthorName; ?></span>
        <?php } ?>

        <?php if ($item->displayCategoryTitle) { ?>
            <span class="uk-badge mod-articles-category-category"><?php echo $item->displayCategoryTitle; ?></span>
        <?php } ?>

        <?php if ($item->displayDate) { ?>
            <span class="mod-articles-category-date"><?php echo $item->displayDate; ?></span>
        <?php } ?>

        <?php if ($params->get('show_tags', 0) && $item->tags->itemTags) { ?>
            <div class="mod-articles-category-tags uk-margin">
                <?php echo LayoutHelper::render('joomla.content.tags', $item->tags->itemTags); ?>
            </div>
        <?php } ?>

        <?php if ($params->get('show_introtext')) { ?>
            <p class="mod-articles-category-introtext">
                <?php echo $item->displayIntrotext; ?>
            </p>
        <?php } ?>

        <?php
        if ($params->get('show_readmore')) {
            echo LayoutHelper::render('joomla.content.readmore', array('item' => $item, 'params' => $item->params, 'link' => $item->link));
        }
        ?>
    </li>
<?php } ?>
