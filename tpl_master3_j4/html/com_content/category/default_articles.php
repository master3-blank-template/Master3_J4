<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Content\Administrator\Extension\ContentComponent;
use Joomla\Component\Content\Site\Helper\AssociationHelper;
use Joomla\Component\Content\Site\Helper\RouteHelper;

$app = Factory::getContainer()->get(Joomla\CMS\Application\SiteApplication::class);

$wa = $this->document->getWebAssetManager();
$wa->useScript('com_content.articles-list');
$wa->addInlineStyle('
.popover {
    padding: .7rem 1rem;
    background-color: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,.08);
}
.popover-arrow {
    display: none;
}
.popover-header {
    margin: 0;
    font-size: inherit;
    line-height: inherit;
    font-weight: bold;
}
');
$show_pagination_limit = $this->params->get('show_pagination_limit');
$filter_field          = $this->params->get('filter_field');

// Create some shortcuts.
$n          = count($this->items);
$listOrder  = $this->escape($this->state->get('list.ordering'));
$listDirn   = $this->escape($this->state->get('list.direction'));
$langFilter = false;

// Tags filtering based on language filter
if (($filter_field === 'tag') && (Multilanguage::isEnabled())) {
    $tagfilter = ComponentHelper::getParams('com_tags')->get('tag_list_language_filter');
    switch ($tagfilter) {
        case 'current_language':
            $langFilter = $app->getLanguage()->getTag();
            break;
        case 'all':
            $langFilter = false;
            break;
        default:
            $langFilter = $tagfilter;
    }
}

// Check for at least one editable article
$isEditable = false;

if (!empty($this->items)) {
    foreach ($this->items as $article) {
        if ($article->params->get('access-edit')) {
            $isEditable = true;
            break;
        }
    }
}

$currentDate = Factory::getDate()->format(Text::_('DATE_FORMAT_LC6'));
?>

<form action="<?php echo htmlspecialchars(Uri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm" class="com-content-category__articles">
    <?php if ($filter_field !== 'hide' || $show_pagination_limit) { ?>
        <div class="uk-flex uk-flex-middle uk-flex-between@m uk-flex-wrap" data-uk-margin>
            <?php if ($filter_field !== 'hide') { ?>
                <div class="com-content__filter uk-button-group uk-form-small uk-margin-right uk-padding-remove">
                    <?php if ($filter_field === 'tag') { ?>
                        <span class="visually-hidden uk-hidden">
                            <label class="filter-search-lbl" for="filter-search">
                                <?php echo Text::_('JOPTION_SELECT_TAG'); ?>
                            </label>
                        </span>
                        <select name="filter_tag" id="filter-search" class="uk-select uk-form-small form-select" onchange="document.adminForm.submit();">
                            <option value=""><?php echo Text::_('JOPTION_SELECT_TAG'); ?></option>
                            <?php echo HTMLHelper::_('select.options', HTMLHelper::_('tag.options', array('filter.published' => array(1), 'filter.language' => $langFilter), true), 'value', 'text', $this->state->get('filter.tag')); ?>
                        </select>
                    <?php } elseif ($filter_field === 'month') { ?>
                        <span class="visually-hidden uk-hidden">
                            <label class="filter-search-lbl" for="filter-search">
                                <?php echo Text::_('JOPTION_SELECT_MONTH'); ?>
                            </label>
                        </span>
                        <select name="filter-search" id="filter-search" class="uk-select uk-form-small form-select" onchange="document.adminForm.submit();">
                            <option value=""><?php echo Text::_('JOPTION_SELECT_MONTH'); ?></option>
                            <?php echo HTMLHelper::_('select.options', HTMLHelper::_('content.months', $this->state), 'value', 'text', $this->state->get('list.filter')); ?>
                        </select>
                    <?php } else { ?>
                        <label class="filter-search-lbl visually-hidden uk-hidden" for="filter-search">
                            <?php echo Text::_('COM_CONTENT_' . $filter_field . '_FILTER_LABEL'); ?>
                        </label>
                        <input type="text" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->state->get('list.filter')); ?>" class="uk-input uk-form-small inputbox" onchange="document.adminForm.submit();" placeholder="<?php echo Text::_('COM_CONTENT_' . $filter_field . '_FILTER_LABEL'); ?>">
                    <?php } ?>

                    <?php if ($filter_field !== 'tag' && $filter_field !== 'month') { ?>
                        <button type="submit" name="filter_submit" class="uk-button-primary uk-button-small"><?php echo Text::_('JGLOBAL_FILTER_BUTTON'); ?></button>
                    <?php } ?>
                    <button type="reset" name="filter-clear-button" class="uk-button-secondary uk-button-small"><?php echo Text::_('JSEARCH_FILTER_CLEAR'); ?></button>
                </div>
            <?php } ?>

            <?php if ($show_pagination_limit) { ?>
                <div>
                    <label for="limit" class="visually-hidden uk-hidden">
                        <?php echo Text::_('JGLOBAL_DISPLAY_NUM'); ?>
                    </label>
                    <?php
                    $limits = [];
                    for ($i = 5; $i <= 30; $i += 5) {
                        $limits[] = HTMLHelper::_('select.option', "$i");
                    }
                    $limits[] = HTMLHelper::_('select.option', '50', Text::_('J50'));
                    $limits[] = HTMLHelper::_('select.option', '100', Text::_('J100'));
                    $limits[] = HTMLHelper::_('select.option', '0', Text::_('JALL'));

                    $selected = !$this->pagination->limit ? 0 : $this->pagination->limit;

                    $html = HTMLHelper::_(
                        'select.genericlist',
                        $limits,
                        $this->pagination->prefix . 'limit',
                        'class="uk-select uk-form-small form-select" onchange="this.form.submit()"',
                        'value',
                        'text',
                        $selected
                    );

                    echo $html;
                    ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

    <?php if (empty($this->items)) { ?>
        <?php if ($this->params->get('show_no_articles', 1)) { ?>
            <div class="uk-alert uk-alert-info">
                <span class="icon-info-circle" aria-hidden="true"></span><span class="visually-hidden"><?php echo Text::_('INFO'); ?></span>
                <?php echo Text::_('COM_CONTENT_NO_ARTICLES'); ?>
            </div>
        <?php } ?>
    <?php } else { ?>
        <table class="com-content-category__table category uk-table uk-table-striped uk-table-hover">
            <caption class="visually-hidden">
                <?php echo Text::_('COM_CONTENT_ARTICLES_TABLE_CAPTION'); ?>
            </caption>
            <?php if ($this->params->get('show_headings')) { ?>
                <thead>
                    <tr>
                        <th scope="col" id="categorylist_header_title">
                            <?php echo HTMLHelper::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder, null, 'asc', '', 'adminForm'); ?>
                        </th>
                        <?php if ($date = $this->params->get('list_show_date')) { ?>
                            <th scope="col" id="categorylist_header_date">
                                <?php if ($date === 'created') { ?>
                                    <?php echo HTMLHelper::_('grid.sort', 'COM_CONTENT_' . $date . '_DATE', 'a.created', $listDirn, $listOrder); ?>
                                <?php } elseif ($date === 'modified') { ?>
                                    <?php echo HTMLHelper::_('grid.sort', 'COM_CONTENT_' . $date . '_DATE', 'a.modified', $listDirn, $listOrder); ?>
                                <?php } elseif ($date === 'published') { ?>
                                    <?php echo HTMLHelper::_('grid.sort', 'COM_CONTENT_' . $date . '_DATE', 'a.publish_up', $listDirn, $listOrder); ?>
                                <?php } ?>
                            </th>
                        <?php } ?>
                        <?php if ($this->params->get('list_show_author')) { ?>
                            <th scope="col" id="categorylist_header_author">
                                <?php echo HTMLHelper::_('grid.sort', 'JAUTHOR', 'author', $listDirn, $listOrder); ?>
                            </th>
                        <?php } ?>
                        <?php if ($this->params->get('list_show_hits')) { ?>
                            <th scope="col" id="categorylist_header_hits">
                                <?php echo HTMLHelper::_('grid.sort', 'JGLOBAL_HITS', 'a.hits', $listDirn, $listOrder); ?>
                            </th>
                        <?php } ?>
                        <?php if ($this->params->get('list_show_votes', 0) && $this->vote) { ?>
                            <th scope="col" id="categorylist_header_votes">
                                <?php echo HTMLHelper::_('grid.sort', 'COM_CONTENT_VOTES', 'rating_count', $listDirn, $listOrder); ?>
                            </th>
                        <?php } ?>
                        <?php if ($this->params->get('list_show_ratings', 0) && $this->vote) { ?>
                            <th scope="col" id="categorylist_header_ratings">
                                <?php echo HTMLHelper::_('grid.sort', 'COM_CONTENT_RATINGS', 'rating', $listDirn, $listOrder); ?>
                            </th>
                        <?php } ?>
                        <?php if ($isEditable) { ?>
                            <th scope="col" id="categorylist_header_edit"><?php echo Text::_('COM_CONTENT_EDIT_ITEM'); ?></th>
                        <?php } ?>
                    </tr>
                </thead>
            <?php } ?>
            <tbody>
                <?php foreach ($this->items as $i => $article) { ?>
                    <?php if ($this->items[$i]->state == ContentComponent::CONDITION_UNPUBLISHED) { ?>
                        <tr class="system-unpublished cat-list-row<?php echo $i % 2; ?>">
                        <?php } else { ?>
                        <tr class="cat-list-row<?php echo $i % 2; ?>">
                        <?php } ?>
                        <th class="list-title" scope="row">
                            <?php if (in_array($article->access, $this->user->getAuthorisedViewLevels())) { ?>
                                <a href="<?php echo Route::_(RouteHelper::getArticleRoute($article->slug, $article->catid, $article->language)); ?>">
                                    <?php echo $this->escape($article->title); ?>
                                </a>
                                <?php if (Associations::isEnabled() && $this->params->get('show_associations')) { ?>
                                    <div class="cat-list-association">
                                        <?php $associations = AssociationHelper::displayAssociations($article->id); ?>
                                        <?php foreach ($associations as $association) { ?>
                                            <?php if ($this->params->get('flags', 1) && $association['language']->image) { ?>
                                                <?php $flag = HTMLHelper::_('image', 'mod_languages/' . $association['language']->image . '.gif', $association['language']->title_native, array('title' => $association['language']->title_native), true); ?>
                                                <a href="<?php echo Route::_($association['item']); ?>"><?php echo $flag; ?></a>
                                            <?php } else { ?>
                                                <?php $class = 'btn btn-secondary btn-sm btn-' . strtolower($association['language']->lang_code); ?>
                                                <a class="<?php echo $class; ?>" title="<?php echo $association['language']->title_native; ?>" href="<?php echo Route::_($association['item']); ?>"><?php echo $association['language']->lang_code; ?>
                                                    <span class="visually-hidden"><?php echo $association['language']->title_native; ?></span>
                                                </a>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <?php
                                echo $this->escape($article->title) . ' : ';
                                $itemId = $app->getMenu()->getActive()->id;
                                $link   = new Uri(Route::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
                                $link->setVar('return', base64_encode(RouteHelper::getArticleRoute($article->slug, $article->catid, $article->language)));
                                ?>
                                <a href="<?php echo $link; ?>" class="register">
                                    <?php echo Text::_('COM_CONTENT_REGISTER_TO_READ_MORE'); ?>
                                </a>
                                <?php if (Associations::isEnabled() && $this->params->get('show_associations')) { ?>
                                    <div class="cat-list-association">
                                        <?php $associations = AssociationHelper::displayAssociations($article->id); ?>
                                        <?php foreach ($associations as $association) { ?>
                                            <?php if ($this->params->get('flags', 1)) { ?>
                                                <?php $flag = HTMLHelper::_('image', 'mod_languages/' . $association['language']->image . '.gif', $association['language']->title_native, array('title' => $association['language']->title_native), true); ?>
                                                <a href="<?php echo Route::_($association['item']); ?>"><?php echo $flag; ?></a>
                                            <?php } else { ?>
                                                <?php $class = 'btn btn-secondary btn-sm btn-' . strtolower($association['language']->lang_code); ?>
                                                <a class="<?php echo $class; ?>" title="<?php echo $association['language']->title_native; ?>" href="<?php echo Route::_($association['item']); ?>"><?php echo $association['language']->lang_code; ?>
                                                    <span class="visually-hidden"><?php echo $association['language']->title_native; ?></span>
                                                </a>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            <?php if ($article->state == ContentComponent::CONDITION_UNPUBLISHED) { ?>
                                <div>
                                    <span class="list-published badge bg-warning text-light">
                                        <?php echo Text::_('JUNPUBLISHED'); ?>
                                    </span>
                                </div>
                            <?php } ?>
                            <?php if ($article->publish_up > $currentDate) { ?>
                                <div>
                                    <span class="list-published badge bg-warning text-light">
                                        <?php echo Text::_('JNOTPUBLISHEDYET'); ?>
                                    </span>
                                </div>
                            <?php } ?>
                            <?php if (!is_null($article->publish_down) && $article->publish_down < $currentDate) { ?>
                                <div>
                                    <span class="list-published badge bg-warning text-light">
                                        <?php echo Text::_('JEXPIRED'); ?>
                                    </span>
                                </div>
                            <?php } ?>
                        </th>
                        <?php if ($this->params->get('list_show_date')) { ?>
                            <td class="list-date small">
                                <?php
                                echo HTMLHelper::_(
                                    'date',
                                    $article->displayDate,
                                    $this->escape($this->params->get('date_format', Text::_('DATE_FORMAT_LC3')))
                                ); ?>
                            </td>
                        <?php } ?>
                        <?php if ($this->params->get('list_show_author', 1)) { ?>
                            <td class="list-author">
                                <?php if (!empty($article->author) || !empty($article->created_by_alias)) { ?>
                                    <?php $author = $article->author ?>
                                    <?php $author = $article->created_by_alias ?: $author; ?>
                                    <?php if (!empty($article->contact_link) && $this->params->get('link_author') == true) { ?>
                                        <?php if ($this->params->get('show_headings')) { ?>
                                            <?php echo HTMLHelper::_('link', $article->contact_link, $author); ?>
                                        <?php } else { ?>
                                            <?php echo Text::sprintf('COM_CONTENT_WRITTEN_BY', HTMLHelper::_('link', $article->contact_link, $author)); ?>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <?php if ($this->params->get('show_headings')) { ?>
                                            <?php echo $author; ?>
                                        <?php } else { ?>
                                            <?php echo Text::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            </td>
                        <?php } ?>
                        <?php if ($this->params->get('list_show_hits', 1)) { ?>
                            <td class="list-hits">
                                <span class="badge bg-info">
                                    <?php if ($this->params->get('show_headings')) { ?>
                                        <?php echo $article->hits; ?>
                                    <?php } else { ?>
                                        <?php echo Text::sprintf('JGLOBAL_HITS_COUNT', $article->hits); ?>
                                    <?php } ?>
                                </span>
                            </td>
                        <?php } ?>
                        <?php if ($this->params->get('list_show_votes', 0) && $this->vote) { ?>
                            <td class="list-votes">
                                <span class="badge bg-success">
                                    <?php if ($this->params->get('show_headings')) { ?>
                                        <?php echo $article->rating_count; ?>
                                    <?php } else { ?>
                                        <?php echo Text::sprintf('COM_CONTENT_VOTES_COUNT', $article->rating_count); ?>
                                    <?php } ?>
                                </span>
                            </td>
                        <?php } ?>
                        <?php if ($this->params->get('list_show_ratings', 0) && $this->vote) { ?>
                            <td class="list-ratings">
                                <span class="badge bg-warning text-light">
                                    <?php if ($this->params->get('show_headings')) { ?>
                                        <?php echo $article->rating; ?>
                                    <?php } else { ?>
                                        <?php echo Text::sprintf('COM_CONTENT_RATINGS_COUNT', $article->rating); ?>
                                    <?php } ?>
                                </span>
                            </td>
                        <?php } ?>
                        <?php if ($isEditable) { ?>
                            <td class="list-edit">
                                <?php if ($article->params->get('access-edit')) { ?>
                                    <?php echo HTMLHelper::_('contenticon.edit', $article, $article->params); ?>
                                <?php } ?>
                            </td>
                        <?php } ?>
                        </tr>
                    <?php } ?>
            </tbody>
        </table>
    <?php } ?>

    <?php // Code to add a link to submit an article.
    ?>
    <?php if ($this->category->getParams()->get('access-create')) { ?>
        <?php echo HTMLHelper::_('contenticon.create', $this->category, $this->category->params); ?>
    <?php } ?>

    <?php // Add pagination links ?>
    <?php if (!empty($this->items)) { ?>
        <?php if (($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) { ?>
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
    <?php } ?>
    <div>
        <input type="hidden" name="filter_order" value="">
        <input type="hidden" name="filter_order_Dir" value="">
        <input type="hidden" name="limitstart" value="">
        <input type="hidden" name="task" value="">
    </div>
</form>
