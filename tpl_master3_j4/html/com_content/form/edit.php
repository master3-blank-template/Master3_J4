<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;

$wa = $this->document->getWebAssetManager();
$wa->useScript('keepalive')
    ->useScript('form.validate')
    ->useScript('com_content.form-edit');

$this->tab_name = 'com-content-form';
$this->ignore_fieldsets = array('image-intro', 'image-full', 'jmetadata', 'item_associations');
$this->useCoreUI = true;

$params = $this->state->get('params');

$editoroptions = isset($params->show_publishing_options);

if (!$editoroptions) {
    $params->show_urls_images_frontend = '0';
}
?>
<div class="edit item-page">
    <?php if ($params->get('show_page_heading')) { ?>
        <h1 class="uk-article-title">
            <?php echo $this->escape($params->get('page_heading')); ?>
        </div>
    <?php } ?>

    <form action="<?php echo Route::_('index.php?option=com_content&a_id=' . (int)$this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-vertical">
        <?php
        echo HTMLHelper::_('uitab.startTabSet', $this->tab_name, ['active' => 'editor', 'recall' => true, 'breakpoint' => 639]);

        // Article
        echo HTMLHelper::_('uitab.addTab', $this->tab_name, 'editor', Text::_('COM_CONTENT_ARTICLE_CONTENT'));
        echo $this->form->renderField('title');
        if (is_null($this->item->id)) {
            echo $this->form->renderField('alias');
        }
        echo $this->form->renderField('articletext');
        if ($this->captchaEnabled) {
            echo $this->form->renderField('captcha');
        }
        echo HTMLHelper::_('uitab.endTab');

        // Images & links
        if ($params->get('show_urls_images_frontend')) {
            echo HTMLHelper::_('uitab.addTab', $this->tab_name, 'images', Text::_('COM_CONTENT_IMAGES_AND_URLS'));
            echo $this->form->renderField('image_intro', 'images');
            echo $this->form->renderField('image_intro_alt', 'images');
            echo $this->form->renderField('image_intro_alt_empty', 'images');
            echo $this->form->renderField('image_intro_caption', 'images');
            echo $this->form->renderField('float_intro', 'images');
            echo $this->form->renderField('image_fulltext', 'images');
            echo $this->form->renderField('image_fulltext_alt', 'images');
            echo $this->form->renderField('image_fulltext_alt_empty', 'images');
            echo $this->form->renderField('image_fulltext_caption', 'images');
            echo $this->form->renderField('float_fulltext', 'images');
            echo $this->form->renderField('urla', 'urls');
            echo $this->form->renderField('urlatext', 'urls');

            echo $this->form->getInput('targeta', 'urls');

            echo $this->form->renderField('urlb', 'urls');
            echo $this->form->renderField('urlbtext', 'urls');

            echo $this->form->getInput('targetb', 'urls');

            echo $this->form->renderField('urlc', 'urls');
            echo $this->form->renderField('urlctext', 'urls');

            echo $this->form->getInput('targetc', 'urls');
            echo HTMLHelper::_('uitab.endTab');
        }

        echo LayoutHelper::render('joomla.edit.params', $this);

        // Publishing
        echo HTMLHelper::_('uitab.addTab', $this->tab_name, 'publishing', Text::_('COM_CONTENT_PUBLISHING'));
        echo $this->form->renderField('transition');
        echo $this->form->renderField('state');
        echo $this->form->renderField('catid');
        echo $this->form->renderField('tags');
        echo $this->form->renderField('note');
        if ($params->get('save_history', 0)) {
            echo $this->form->renderField('version_note');
        }
        if ($params->get('show_publishing_options', 1) == 1) {
            echo $this->form->renderField('created_by_alias');
        }
        if ($this->item->params->get('access-change')) {
            echo $this->form->renderField('featured');
            if ($params->get('show_publishing_options', 1) == 1) {
                echo $this->form->renderField('featured_up');
                echo $this->form->renderField('featured_down');
                echo $this->form->renderField('publish_up');
                echo $this->form->renderField('publish_down');
            }
        }
        echo $this->form->renderField('access');
        if (is_null($this->item->id)) {
            echo Text::_('COM_CONTENT_ORDERING');
        }
        echo HTMLHelper::_('uitab.endTab');

        // Multilanguages
        if (Multilanguage::isEnabled()) {
            echo HTMLHelper::_('uitab.addTab', $this->tab_name, 'language', Text::_('JFIELD_LANGUAGE_LABEL'));
            echo $this->form->renderField('language');
            echo HTMLHelper::_('uitab.endTab');
        } else {
            echo $this->form->renderField('language');
        }

        // Metadata
        if ($params->get('show_publishing_options', 1) == 1) {
            echo HTMLHelper::_('uitab.addTab', $this->tab_name, 'metadata', Text::_('COM_CONTENT_METADATA'));
            echo $this->form->renderField('metadesc');
            echo $this->form->renderField('metakey');
            echo HTMLHelper::_('uitab.endTab');
        }

        echo HTMLHelper::_('uitab.endTabSet');
        ?>

        <input type="hidden" name="task" value="">
        <input type="hidden" name="return" value="<?php echo $this->return_page; ?>">
        <?php echo HTMLHelper::_('form.token'); ?>

        <div class="uk-margin uk-flex uk-flex-wrap" data-uk-margin>
            <button type="button" class="uk-button uk-button-primary uk-margin-right" data-submit-task="article.save">
                <?php echo Text::_('JSAVE'); ?>
            </button>
            <?php if ($this->showSaveAsCopy) { ?>
                <button type="button" class="uk-button uk-button-primary uk-margin-right" data-submit-task="article.save2copy">
                    <?php echo Text::_('JSAVEASCOPY'); ?>
                </button>
            <?php } ?>
            <button type="button" class="uk-button uk-button-danger uk-margin-right" data-submit-task="article.cancel">
                <?php echo Text::_('JCANCEL'); ?>
            </button>
            <?php
            if ($params->get('save_history', 0) && $this->item->id) {
                echo $this->form->getInput('contenthistory');
            }
            ?>
        </div>
    </form>
</div>
