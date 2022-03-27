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
<dd class="uk-flex uk-flex-middle published">
    <?php
    if ($jsIcons) {
        echo '<span data-uk-icon="icon:calendar" aria-hidden="true"></span>&nbsp;';
    }
    ?>
    <time datetime="<?php echo HTMLHelper::_('date', $displayData['item']->publish_up, 'c'); ?>" itemprop="datePublished">
        <?php echo Text::sprintf('COM_CONTENT_PUBLISHED_DATE_ON', HTMLHelper::_('date', $displayData['item']->publish_up, Text::_('DATE_FORMAT_LC3'))); ?>
    </time>
</dd>
