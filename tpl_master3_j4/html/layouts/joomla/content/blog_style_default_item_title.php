<?php

/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   (C) 2013 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;

// Create a shortcut for params.
$params  = $displayData->params;
$canEdit = $displayData->params->get('access-edit');

$currentDate = Factory::getDate()->format(Text::_('DATE_FORMAT_LC6'));
?>
<?php if ($displayData->state == 0 || $params->get('show_title') || ($params->get('show_author') && !empty($displayData->author))) { ?>
    <div class="page-header">
        <?php if ($params->get('show_title')) { ?>
            <h2 itemprop="name">
                <?php if ($params->get('link_titles') && ($params->get('access-view') || $params->get('show_noauth', '0') == '1')) { ?>
                    <a href="<?php echo Route::_(
                                    RouteHelper::getArticleRoute($displayData->slug, $displayData->catid, $displayData->language)
                                ); ?>" itemprop="url">
                        <?php echo $this->escape($displayData->title); ?>
                    </a>
                <?php } else { ?>
                    <?php echo $this->escape($displayData->title); ?>
                <?php } ?>
            </h2>
        <?php
        }
        $badges = '';
        if ($displayData->state == 0) {
            $badges .= '<span class="uk-label uk-label-warning uk-margin-small-right uk-text-uppercase">' . Text::_('JUNPUBLISHED') . '</span>';
        }
        if ($displayData->publish_up > $currentDate) {
            $badges .= '<span class="uk-label uk-label-warning uk-margin-small-right uk-text-uppercase">' . Text::_('JNOTPUBLISHEDYET') . '</span>';
        }
        if ($displayData->publish_down !== null && $displayData->publish_down < $currentDate) {
            $badges .= '<span class="uk-label uk-label-warning uk-margin-small-right uk-text-uppercase">' . Text::_('JEXPIRED') . '</span>';
        }
        if ($badges) {
            echo '<div class="uk-flex uk-margin">' . $badges . '</div>';
        }
        ?>
    </div>
<?php } ?>
