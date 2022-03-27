<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Event\GenericEvent;

$app = Factory::getContainer()->get(Joomla\CMS\Application\SiteApplication::class);

$this->category->text = $this->category->description;
$app->getDispatcher()->dispatch('onContentPrepare', new GenericEvent('onContentPrepare', [$this->category->extension . '.categories', &$this->category, &$this->params, 0]));
$this->category->description = $this->category->text;

$results = $app->getDispatcher()->dispatch('onContentAfterTitle', new GenericEvent('onContentAfterTitle', [$this->category->extension . '.categories', &$this->category, &$this->params, 0]));
$afterDisplayTitle = trim(implode("\n", $results->getArgument('result') ?? []));

$results = $app->getDispatcher()->dispatch('onContentBeforeDisplay', new GenericEvent('onContentBeforeDisplay', [$this->category->extension . '.categories', &$this->category, &$this->params, 0]));
$beforeDisplayContent = trim(implode("\n", $results->getArgument('result') ?? []));

$results = $app->getDispatcher()->dispatch('onContentAfterDisplay', new GenericEvent('onContentAfterDisplay', [$this->category->extension . '.categories', &$this->category, &$this->params, 0]));
$afterDisplayContent = trim(implode("\n", $results->getArgument('result') ?? []));

$htag    = $this->params->get('show_page_heading') ? 'h2' : 'h1';

?>
<div class="com-content-category-blog blog" itemscope itemtype="https://schema.org/Blog">
    <?php if ($this->params->get('show_page_heading')) { ?>
        <div class="page-header">
            <h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
        </div>
    <?php } ?>

    <?php if ($this->params->get('show_category_title', 1)) { ?>
        <<?php echo $htag; ?>><?php echo $this->category->title; ?></<?php echo $htag; ?>>
    <?php } ?>
    <?php echo $afterDisplayTitle; ?>

    <?php if ($this->params->get('show_cat_tags', 1) && !empty($this->category->tags->itemTags)) { ?>
        <?php $this->category->tagLayout = new FileLayout('joomla.content.tags'); ?>
        <?php echo $this->category->tagLayout->render($this->category->tags->itemTags); ?>
    <?php } ?>

    <?php if ($beforeDisplayContent || $afterDisplayContent || $this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) { ?>
        <div class="category-desc clearfix">
            <?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) { ?>
                <?php echo LayoutHelper::render(
                    'joomla.html.image',
                    [
                        'src' => $this->category->getParams()->get('image'),
                        'alt' => empty($this->category->getParams()->get('image_alt')) && empty($this->category->getParams()->get('image_alt_empty')) ? false : $this->category->getParams()->get('image_alt'),
                    ]
                ); ?>
            <?php } ?>
            <?php echo $beforeDisplayContent; ?>
            <?php if ($this->params->get('show_description') && $this->category->description) { ?>
                <?php echo HTMLHelper::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
            <?php } ?>
            <?php echo $afterDisplayContent; ?>
        </div>
    <?php } ?>

    <?php if (empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items)) { ?>
        <?php if ($this->params->get('show_no_articles', 1)) { ?>
            <div class="uk-alert uk-alert-info">
                <?php echo Text::_('COM_CONTENT_NO_ARTICLES'); ?>
            </div>
        <?php } ?>
    <?php } ?>

    <?php $leadingcount = 0; ?>
    <?php if (!empty($this->lead_items)) { ?>
        <div class="uk-child-width-1-1 blog-items items-leading <?php echo $this->params->get('blog_class_leading'); ?>" data-uk-grid>
            <?php foreach ($this->lead_items as &$item) { ?>
                <div class="blog-item" itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
                    <div class="uk-panel">
                        <?php
                        $this->item = &$item;
                        echo $this->loadTemplate('item');
                        ?>
                    </div>
                </div>
                <?php $leadingcount++; ?>
            <?php } ?>
        </div>
    <?php } ?>

    <?php
    $introcount = count($this->intro_items);
    $counter = 0;
    ?>

    <?php if (!empty($this->intro_items)) { ?>
        <?php $blogClass = $this->params->get('blog_class', ''); ?>
        <div class="uk-child-width-1-<?php echo (int)$this->params->get('num_columns', 1); ?>@m blog-items <?php echo $blogClass; ?>" data-uk-grid="masonry:true">
            <?php foreach ($this->intro_items as $key => &$item) { ?>
                <div class="blog-item" itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
                    <div class="uk-panel">
                        <?php
                        $this->item = &$item;
                        echo $this->loadTemplate('item');
                        ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

    <?php if (!empty($this->link_items)) { ?>
        <div class="items-more">
            <?php echo $this->loadTemplate('links'); ?>
        </div>
    <?php } ?>

    <?php if ($this->maxLevel != 0 && !empty($this->children[$this->category->id])) { ?>
        <hr class="uk-margin-medium">
        <div class="cat-children">
            <?php if ($this->params->get('show_category_heading_title_text', 1) == 1) { ?>
                <h3><?php echo Text::_('JGLOBAL_SUBCATEGORIES'); ?></h3>
            <?php } ?>
            <?php echo $this->loadTemplate('children'); ?>
        </div>
    <?php } ?>

    <?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) { ?>
        <div class="uk-flex uk-flex-between@m uk-flex-middle uk-flex-wrap uk-margin-top navigation">
            <div class="com-content-category-blog__pagination">
                <?php echo $this->pagination->getPagesLinks(); ?>
            </div>
            <?php if ($this->params->def('show_pagination_results', 1)) { ?>
                <div class="counter">
                    <?php echo $this->pagination->getPagesCounter(); ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>
