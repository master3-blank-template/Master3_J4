<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  Content.pagebreak
 *
 * @copyright   (C) 2018 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

/**
 * @var $links   array    Array with keys 'previous' and 'next' with non-SEO links to the previous and next pages
 * @var $page    integer  The page number
 */

$app  = Factory::getContainer()->get(Joomla\CMS\Application\SiteApplication::class);
$lang = $app->getLanguage();
$jsIcons = $app->getTemplate(true)->params->get('jsIcons', 'none') != 'none';
?>
<ul class="uk-subnav pagination">
    <li class="previous page-item">
        <?php
        if ($links['previous']) {
            $direction = $lang->isRtl() ? 'right' : 'left';
            $title = htmlspecialchars($this->list[$page]->title, ENT_QUOTES, 'UTF-8');
            $ariaLabel = Text::_('JPREVIOUS') . ': ' . $title . ' (' . Text::sprintf('JLIB_HTML_PAGE_CURRENT_OF_TOTAL', $page, $n) . ')';
        ?>
            <a class="uk-flex-inline uk-flex-middle page-link" href="<?php echo Route::_($links['previous']); ?>" title="<?php echo $title; ?>" aria-label="<?php echo $ariaLabel; ?>" rel="prev">
                <?php
                if ($jsIcons) {
                    echo '<span data-uk-icon="icon:chevron-' . $direction . '" aria-hidden="true"></span>&nbsp;';
                }
                echo Text::_('JPREV');
                ?>
            </a>
        <?php } ?>
    </li>
    <li class="next page-item">
        <?php
        if ($links['next']) {
            $direction = $lang->isRtl() ? 'left' : 'right';
            $title = htmlspecialchars($this->list[$page + 2]->title, ENT_QUOTES, 'UTF-8');
            $ariaLabel = Text::_('JNEXT') . ': ' . $title . ' (' . Text::sprintf('JLIB_HTML_PAGE_CURRENT_OF_TOTAL', ($page + 2), $n) . ')';
        ?>
            <a class="uk-flex-inline uk-flex-middle page-link" href="<?php echo Route::_($links['next']); ?>" title="<?php echo $title; ?>" aria-label="<?php echo $ariaLabel; ?>" rel="next">
                <?php
                echo Text::_('JNEXT');
                if ($jsIcons) {
                    echo '&nbsp;<span data-uk-icon="icon:chevron-' . $direction . '" aria-hidden="true"></span>';
                }
                ?>
            </a>
        <?php } ?>
    </li>
</ul>
