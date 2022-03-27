<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   (C) 2010 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;

$app = Factory::getContainer()->get(Joomla\CMS\Application\SiteApplication::class);

$lang   = $app->getLanguage();
$user   = $app->getIdentity();
$groups = $user->getAuthorisedViewLevels();

if ($this->maxLevel != 0 && count($this->children[$this->category->id]) > 0) {
    foreach ($this->children[$this->category->id] as $id => $child) {
        // Check whether category access level allows access to subcategories.
        if (in_array($child->access, $groups)) {
            if ($this->params->get('show_empty_categories') || $child->numitems || count($child->getChildren())) {
            ?>
            <div class="item-child">
                <?php if ($lang->isRtl()) { ?>
                    <h3 class="uk-h5 uk-flex uk-flex-middle item-title">
                        <?php if ($this->params->get('show_cat_num_articles', 1)) { ?>
                            <span class="uk-badge uk-margin-small-left" titlr="<?php echo Text::_('COM_CONTENT_NUM_ITEMS'); ?>">
                                <?php echo $child->getNumItems(true); ?>
                            </span>
                        <?php } ?>
                        <a href="<?php echo Route::_(RouteHelper::getCategoryRoute($child->id, $child->language)); ?>">
                            <?php echo $this->escape($child->title); ?>
                        </a>
                        <?php if ($this->maxLevel > 1 && count($child->getChildren()) > 0) { ?>
                            <a href="#category-<?php echo $child->id; ?>" data-bs-toggle="collapse" class="btn btn-sm float-end" aria-label="<?php echo Text::_('JGLOBAL_EXPAND_CATEGORIES'); ?>"><span class="icon-plus" aria-hidden="true"></span></a>
                        <?php } ?>
                    </h3>
                <?php } else { ?>
                    <h3 class="uk-h5 uk-flex uk-flex-middle item-title">
                        <?php if ($this->maxLevel > 1 && count($child->getChildren()) > 0) { ?>
                            <a href="#category-<?php echo $child->id; ?>" class="uk-margin-right" data-uk-toggle="#category-<?php echo $child->id; ?>" aria-label="<?php echo Text::_('JGLOBAL_EXPAND_CATEGORIES'); ?>">
                                <span data-uk-icon="icon:chevron-right" aria-hidden="true"></span>
                            </a>
                        <?php } ?>
                        <a href="<?php echo Route::_(RouteHelper::getCategoryRoute($child->id, $child->language)); ?>">
                            <?php echo $this->escape($child->title); ?>
                        </a>
                        <?php if ($this->params->get('show_cat_num_articles', 1)) { ?>
                            <span class="uk-badge uk-margin-small-left" title="<?php echo Text::_('COM_CONTENT_NUM_ITEMS'); ?>">
                                <?php echo $child->getNumItems(true); ?>
                            </span>
                        <?php } ?>
                    </h3>
                <?php } ?>

                <?php if ($this->params->get('show_subcat_desc') == 1) { ?>
                    <?php if ($child->description) { ?>
                        <div class="uk-margin category-desc">
                            <?php echo HTMLHelper::_('content.prepare', $child->description, '', 'com_content.category'); ?>
                        </div>
                    <?php } ?>
                <?php } ?>

                <?php if ($this->maxLevel > 1 && count($child->getChildren()) > 0) { ?>
                    <div id="category-<?php echo $child->id; ?>" class="children uk-margin-medium-left" hidden>
                        <?php
                        $this->children[$child->id] = $child->getChildren();
                        $this->category = $child;
                        $this->maxLevel--;
                        echo $this->loadTemplate('children');
                        $this->category = $child->getParent();
                        $this->maxLevel++;
                        ?>
                    </div>
                <?php } ?>
            </div>
            <?php
            }
        }
    }
}
