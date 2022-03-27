<?php

/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   (C) 2017 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

?>
<dl class="uk-description-list article-info uk-text-muted">

    <?php if ($displayData['params']->get('info_block_show_title', 1)) { ?>
        <dt class="uk-margin-small-bottom article-info-term"><?php echo Text::_('COM_CONTENT_ARTICLE_INFO'); ?></dt>
    <?php } ?>

    <?php if ($displayData['params']->get('show_author') && !empty($displayData['item']->author)) { ?>
        <?php echo $this->sublayout('author', $displayData); ?>
    <?php } ?>

    <?php if ($displayData['params']->get('show_parent_category') && !empty($displayData['item']->parent_id)) { ?>
        <?php echo $this->sublayout('parent_category', $displayData); ?>
    <?php } ?>

    <?php if ($displayData['params']->get('show_category')) { ?>
        <?php echo $this->sublayout('category', $displayData); ?>
    <?php } ?>

    <?php if ($displayData['params']->get('show_associations')) { ?>
        <?php echo $this->sublayout('associations', $displayData); ?>
    <?php } ?>

    <?php if ($displayData['params']->get('show_create_date')) { ?>
        <?php echo $this->sublayout('create_date', $displayData); ?>
    <?php } ?>

    <?php if ($displayData['params']->get('show_publish_date')) { ?>
        <?php echo $this->sublayout('publish_date', $displayData); ?>
    <?php } ?>

    <?php if ($displayData['params']->get('show_modify_date')) { ?>
        <?php echo $this->sublayout('modify_date', $displayData); ?>
    <?php } ?>

    <?php if ($displayData['params']->get('show_hits')) { ?>
        <?php echo $this->sublayout('hits', $displayData); ?>
    <?php } ?>
</dl>
