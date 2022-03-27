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
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;

$jsIcons = Factory::getContainer()
    ->get(Joomla\CMS\Application\SiteApplication::class)
    ->getTemplate(true)
    ->params
    ->get('jsIcons', 'none') != 'none';

?>
<dd class="uk-flex uk-flex-middle category-name">
    <?php
    if ($jsIcons) {
        echo '<span data-uk-icon="icon:folder" aria-hidden="true"></span>&nbsp;';
    }
    $title = $this->escape($displayData['item']->category_title);
    if ($displayData['params']->get('link_category') && !empty($displayData['item']->catid)) {
        $url = '<a href="' . Route::_(
            RouteHelper::getCategoryRoute($displayData['item']->catid, $displayData['item']->category_language)
        ) . '" itemprop="genre">' . $title . '</a>';
        echo '<span>' . Text::sprintf('COM_CONTENT_CATEGORY', $url) . '</span>';
    } else {
        echo '<span>' . Text::sprintf('COM_CONTENT_CATEGORY', '<span itemprop="genre">' . $title . '</span>') . '</span>';
    }
    ?>
</dd>
