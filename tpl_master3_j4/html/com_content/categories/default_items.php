<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   (C) 2010 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;

if ($this->maxLevelcat != 0 && count($this->items[$this->parent->id]) > 0) {
?>
    <div class="com-content-categories__items">
        <?php foreach ($this->items[$this->parent->id] as $id => $item) { ?>
            <?php if ($this->params->get('show_empty_categories_cat') || $item->numitems || count($item->getChildren())) { ?>
                <div class="com-content-categories__item">
                    <div class="com-content-categories__item-title-wrapper">
                        <div class="uk-flex-inline uk-flex-middle com-content-categories__item-title">
                            <a href="<?php echo Route::_(RouteHelper::getCategoryRoute($item->id, $item->language)); ?>">
                                <?php echo $this->escape($item->title); ?>
                            </a>
                            <?php if ($this->params->get('show_cat_num_articles_cat') == 1) { ?>
                                &nbsp;<span class="uk-badge" data-uk-tooltip="<?php echo Text::_('COM_CONTENT_NUM_ITEMS'); ?>">
                                    <?php echo $item->numitems; ?>
                                </span>
                            <?php } ?>
                        </div>
                        <?php if (count($item->getChildren()) > 0 && $this->maxLevelcat > 1) { ?>
                            <button type="button" id="category-btn-<?php echo $item->id; ?>" data-category-id="<?php echo $item->id; ?>" class="uk-button uk-button-link" aria-expanded="false" aria-label="<?php echo Text::_('JGLOBAL_EXPAND_CATEGORIES'); ?>">
                                <span data-uk-icon="icon:chevron-right" aria-hidden="true"></span>
                            </button>
                        <?php } ?>
                    </div>
                    <?php if ($this->params->get('show_description_image') && $item->getParams()->get('image')) { ?>
                        <img src="<?php echo $item->getParams()->get('image'); ?>" alt="<?php echo htmlspecialchars($item->getParams()->get('image_alt'), ENT_COMPAT, 'UTF-8'); ?>">
                    <?php } ?>
                    <?php if ($this->params->get('show_subcat_desc_cat') == 1) { ?>
                        <?php if ($item->description) { ?>
                            <div class="com-content-categories__description category-desc">
                                <?php echo HTMLHelper::_('content.prepare', $item->description, '', 'com_content.categories'); ?>
                            </div>
                        <?php } ?>
                    <?php } ?>

                    <?php if (count($item->getChildren()) > 0 && $this->maxLevelcat > 1) { ?>
                        <div class="com-content-categories__children" id="category-<?php echo $item->id; ?>" hidden="">
                            <?php
                            $this->items[$item->id] = $item->getChildren();
                            $this->parent = $item;
                            $this->maxLevelcat--;
                            echo $this->loadTemplate('items');
                            $this->parent = $item->getParent();
                            $this->maxLevelcat++;
                            ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
<?php
}
