<?php

/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   (C) 2014 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

$item    = $displayData['data'];
$display = $item->text;
$app     = Factory::getContainer()->get(Joomla\CMS\Application\SiteApplication::class);
$jsIcons = $app->getTemplate(true)->params->get('jsIcons', 'none') != 'none';

switch ((string) $item->text) {
    // Check for "Start" item
    case Text::_('JLIB_HTML_START'):
        $icon = $jsIcons ? ($app->getLanguage()->isRtl() ? 'arrow-right' : 'arrow-left') : '';
        $aria = Text::sprintf('JLIB_HTML_GOTO_POSITION', strtolower($item->text));
        break;

    // Check for "Prev" item
    case $item->text === Text::_('JPREV'):
        $item->text = Text::_('JPREVIOUS');
        $icon = $jsIcons ? ($app->getLanguage()->isRtl() ? 'chevron-right' : 'chevron-left') : '';
        $aria = Text::sprintf('JLIB_HTML_GOTO_POSITION', strtolower($item->text));
        break;

    // Check for "Next" item
    case Text::_('JNEXT'):
        $icon = $jsIcons ? ($app->getLanguage()->isRtl() ? 'chevron-left' : 'chevron-right') : '';
        $aria = Text::sprintf('JLIB_HTML_GOTO_POSITION', strtolower($item->text));
        break;

    // Check for "End" item
    case Text::_('JLIB_HTML_END'):
        $icon = $jsIcons ? ($app->getLanguage()->isRtl() ? 'arrow-left' : 'arrow-right') : '';
        $aria = Text::sprintf('JLIB_HTML_GOTO_POSITION', strtolower($item->text));
        break;

    default:
        $icon = '';
        $aria = Text::sprintf('JLIB_HTML_GOTO_PAGE', strtolower($item->text));
        break;
}

if ($icon) {
    $display = '<span data-uk-icon="icon:' . $icon . '" aria-hidden="true"></span>';
}

if ($displayData['active']) {
    if ($item->base > 0) {
        $limit = 'limitstart.value=' . $item->base;
    } else {
        $limit = 'limitstart.value=0';
    }

    $class = 'uk-active';

    $link = 'href="' . $item->link . '"';
} else {
    $class = (property_exists($item, 'active') && $item->active) ? 'uk-active' : 'uk-disabled';
}

?>
<?php if ($displayData['active']) { ?>
    <li class="page-item">
        <a aria-label="<?php echo $aria; ?>" data-uk-tooltip="<?php echo $aria; ?>" <?php echo $link; ?> class="page-link">
            <?php echo $display; ?>
        </a>
    </li>
<?php } elseif (isset($item->active) && $item->active) { ?>
    <?php $aria = Text::sprintf('JLIB_HTML_PAGE_CURRENT', strtolower($item->text)); ?>
    <li class="<?php echo $class; ?> page-item">
        <span aria-current="true" aria-label="<?php echo $aria; ?>" data-uk-tooltip="<?php echo $aria; ?>" class="page-link"><?php echo $display; ?></span>
    </li>
<?php } else { ?>
    <li class="<?php echo $class; ?> page-item">
        <span data-uk-tooltip="<?php echo $aria; ?>" class="page-link" aria-hidden="true"><?php echo $display; ?></span>
    </li>
<?php } ?>
