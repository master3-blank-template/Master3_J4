<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_wrapper
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

$this->document->getWebAssetManager()
    ->registerAndUseScript('com_wrapper.iframe', 'com_wrapper/iframe-height.min.js', [], ['defer' => true]);

if ($this->escape($this->params->get('page_heading'))) {
    $title = $this->escape($this->params->get('page_heading'));
} else {
    $title = $this->escape($this->params->get('page_title'));
}
?>
<div class="com-wrapper contentpane">
    <?php if ($this->params->get('show_page_heading')) { ?>
        <div class="page-header">
            <h1><?php echo $title; ?></h1>
        </div>
    <?php } ?>
    <iframe <?php echo $this->wrapper->load; ?> id="blockrandom" name="iframe"
        src="<?php echo $this->escape($this->wrapper->url); ?>"
        width="<?php echo $this->escape($this->params->get('width')); ?>"
        height="<?php echo $this->escape($this->params->get('height')); ?>"
        loading="<?php echo $this->params->get('lazyloading', 'lazy'); ?>"
        title="<?php echo $title; ?>"
        class="com-wrapper__iframe wrapper <?php echo $this->pageclass_sfx; ?>"
    >
        <?php echo Text::_('COM_WRAPPER_NO_IFRAMES'); ?>
    </iframe>
</div>
