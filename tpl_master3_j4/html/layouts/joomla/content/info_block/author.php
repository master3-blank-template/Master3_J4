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
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

$jsIcons = Factory::getContainer()
    ->get(Joomla\CMS\Application\SiteApplication::class)
    ->getTemplate(true)
    ->params
    ->get('jsIcons', 'none') != 'none';

?>
<dd class="uk-flex uk-flex-middle createdby" itemprop="author" itemscope itemtype="https://schema.org/Person">
    <?php
    if ($jsIcons) {
        echo '<span data-uk-icon="icon:user" aria-hidden="true"></span>&nbsp;';
    }
    $author = ($displayData['item']->created_by_alias ?: $displayData['item']->author);
    $author = '<span itemprop="name">' . $author . '</span>';
    if (!empty($displayData['item']->contact_link) && $displayData['params']->get('link_author') == true) {
        echo '<span>' . Text::sprintf('COM_CONTENT_WRITTEN_BY', HTMLHelper::_('link', $displayData['item']->contact_link, $author, array('itemprop' => 'url'))) . '</span>';
    } else {
        echo '<span>' . Text::sprintf('COM_CONTENT_WRITTEN_BY', $author) . '</span>';
    }
    ?>
</dd>
