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
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

$params    = $displayData['params'];
$item      = $displayData['item'];
$app       = Factory::getContainer()->get(Joomla\CMS\Application\SiteApplication::class);
$direction = $app->getLanguage()->isRtl() ? 'left' : 'right';
$template  = $app->getTemplate(true);
$jsIcons   = $app->getTemplate(true)->params->get('jsIcons', 'none') != 'none';
?>

<div class="uk-margin-top readmore">
    <?php if (!$params->get('access-view')) { ?>
        <a class="uk-button uk-button-link uk-flex-inline uk-flex-middle" href="<?php echo $displayData['link']; ?>" aria-label="<?php echo Text::_('JGLOBAL_REGISTER_TO_READ_MORE') . ' ' . $this->escape($item->title); ?>">
            <?php
            if ($jsIcons) {
                echo '<span data-uk-icon="icon:chevron-' . $direction . '" aria-hidden="true"></span>';
            }
            echo '<span>' . Text::_('JGLOBAL_REGISTER_TO_READ_MORE') . '</span>';
            ?>
        </a>
    <?php } elseif ($readmore = $item->alternative_readmore) { ?>
        <a class="uk-button uk-button-link uk-flex-inline uk-flex-middle" href="<?php echo $displayData['link']; ?>" aria-label="<?php echo $this->escape($readmore . ' ' . $item->title); ?>">
            <?php
            if ($jsIcons) {
                echo '<span data-uk-icon="icon:chevron-' . $direction . '" aria-hidden="true"></span>';
            }
            echo $readmore;
            if ($params->get('show_readmore_title', 0) != 0) {
                echo '<span>' . HTMLHelper::_('string.truncate', $item->title, $params->get('readmore_limit')) . '</span>';
            }
            ?>
        </a>
    <?php } elseif ($params->get('show_readmore_title', 0) == 0) { ?>
        <a class="uk-button uk-button-link uk-flex-inline uk-flex-middle" href="<?php echo $displayData['link']; ?>" aria-label="<?php echo Text::sprintf('JGLOBAL_READ_MORE_TITLE', $this->escape($item->title)); ?>">
            <?php
            if ($jsIcons) {
                echo '<span data-uk-icon="icon:chevron-' . $direction . '" aria-hidden="true"></span>';
            }
            echo '<span>' . Text::_('JGLOBAL_READ_MORE') . '</span>';
            ?>
        </a>
    <?php } else { ?>
        <a class="uk-button uk-button-link uk-flex-inline uk-flex-middle" href="<?php echo $displayData['link']; ?>" aria-label="<?php echo Text::sprintf('JGLOBAL_READ_MORE_TITLE', $this->escape($item->title)); ?>">
            <?php
            if ($jsIcons) {
                echo '<span data-uk-icon="icon:chevron-' . $direction . '" aria-hidden="true"></span>';
            }
            echo '<span>' . Text::sprintf(
                'JGLOBAL_READ_MORE_TITLE',
                HTMLHelper::_('string.truncate', $item->title, $params->get('readmore_limit'))
            ) . '</span>';
            ?>
        </a>
    <?php } ?>
</div>
