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

$jsIcons = Factory::getContainer()
    ->get(Joomla\CMS\Application\SiteApplication::class)
    ->getTemplate(true)
    ->params
    ->get('jsIcons', 'none') != 'none';

?>
<dd class="uk-flex uk-flex-middle parent-category-name">
    <?php
    if ($jsIcons) {
        echo '<span data-uk-icon="icon:folder" aria-hidden="true"></span>&nbsp;';
    }
    $title = $this->escape($displayData['item']->parent_title);
    if ($displayData['params']->get('link_parent_category') && !empty($displayData['item']->parent_id)) {
        $url = '<a href="' . Route::_(
            RouteHelper::getCategoryRoute($displayData['item']->parent_id, $displayData['item']->parent_language)
        ) . '" itemprop="genre">' . $title . '</a>';
        echo '<span>' . Text::sprintf('COM_CONTENT_PARENT', $url) . '</span>';
    } else {
        echo '<span>' . Text::sprintf('COM_CONTENT_PARENT', '<span itemprop="genre">' . $title . '</span>') . '</span>';
    }
    ?>
</dd>
