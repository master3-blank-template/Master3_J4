<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

?>
<div class="com-content-archive archive">
    <?php if ($this->params->get('show_page_heading')) { ?>
        <div class="page-header">
            <h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
        </div>
    <?php } ?>

    <form id="adminForm" action="<?php echo Route::_('index.php'); ?>" method="post" class="uk-card uk-card-default uk-card-body uk-card-small uk-margin-medium com-content-archive__form">
        <div class="filter-search uk-grid-small" data-uk-grid>
            <?php if ($this->params->get('filter_field') !== 'hide') { ?>
            <div>
                <label class="filter-search-lbl visually-hidden uk-hidden" for="filter-search"><?php echo Text::_('COM_CONTENT_TITLE_FILTER_LABEL') . '&#160;'; ?></label>
                <input type="text" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->filter); ?>" class="uk-input uk-form-small uk-width-small inputbox" onchange="document.getElementById('adminForm').submit();" placeholder="<?php echo Text::_('COM_CONTENT_TITLE_FILTER_LABEL'); ?>">
            </div>
            <?php } ?>

            <div><?php echo str_replace('form-select', 'uk-select uk-form-small', $this->form->monthField); ?></div>
            <div><?php echo str_replace('form-select', 'uk-select uk-form-small', $this->form->yearField); ?></div>
            <div><?php echo str_replace('form-select', 'uk-select uk-form-small', $this->form->limitField); ?></div>

            <div><button type="submit" class="uk-button-primary uk-button-small" style="vertical-align: top;"><?php echo Text::_('JGLOBAL_FILTER_BUTTON'); ?></button></div>

            <input type="hidden" name="view" value="archive">
            <input type="hidden" name="option" value="com_content">
            <input type="hidden" name="limitstart" value="0">
        </div>
    </form>
    <?php echo $this->loadTemplate('items'); ?>
</div>
