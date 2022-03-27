<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

?>
<div class="blog-featured" itemscope itemtype="https://schema.org/Blog">
    <?php if ($this->params->get('show_page_heading') != 0) { ?>
        <div class="page-header">
            <h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
        </div>
    <?php } ?>

    <?php $leadingcount = 0; ?>
    <?php if (!empty($this->lead_items)) { ?>
        <div class="uk-child-width-1-1 blog-items items-leading <?php echo $this->params->get('blog_class_leading'); ?>" data-uk-grid>
            <?php foreach ($this->lead_items as &$item) { ?>
                <div class="blog-item" itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
                    <?php
                    $this->item = &$item;
                    echo $this->loadTemplate('item');
                    ?>
                </div>
                <?php $leadingcount++; ?>
            <?php } ?>
        </div>
    <?php } ?>

    <?php if (!empty($this->intro_items)) { ?>
        <?php $blogClass = $this->params->get('blog_class', ''); ?>
        <div class="uk-child-width-1-<?php echo (int) $this->params->get('num_columns', 1); ?>@m blog-items <?php echo $blogClass; ?>" data-uk-grid="masonry:true">
            <?php foreach ($this->intro_items as $key => &$item) { ?>
                <div class="blog-item" itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
                    <?php
                    $this->item = &$item;
                    echo $this->loadTemplate('item');
                    ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

    <?php if (!empty($this->link_items)) { ?>
        <div class="items-more">
            <?php echo $this->loadTemplate('links'); ?>
        </div>
    <?php } ?>

    <?php if ($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2 && $this->pagination->pagesTotal > 1)) { ?>
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
