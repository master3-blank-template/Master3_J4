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
use Joomla\CMS\Router\Route;
use Joomla\Component\Tags\Site\Helper\RouteHelper;
use Joomla\Registry\Registry;

$app = Factory::getContainer()->get(Joomla\CMS\Application\SiteApplication::class);
$authorised = $app->getIdentity()->getAuthorisedViewLevels();
$jsIcons = $app->getTemplate(true)->params->get('jsIcons', 'none') != 'none';

?>
<?php if (!empty($displayData)) { ?>
    <div class="uk-flex uk-margin tags" data-uk-margin>
        <?php
        if ($jsIcons) {
            echo '<span class="uk-margin-small-right" data-uk-icon="icon:tag" aria-hidden="true"></span>';
        }
        foreach ($displayData as $i => $tag) {
            if (in_array($tag->access, $authorised)) {
                $tagParams = new Registry($tag->params);
                $link_class = $tagParams->get('tag_link_class', '');
                ?>
                <span class="uk-label uk-display-inline-blick uk-margin-small-right tag-<?php echo $tag->tag_id; ?> tag-list<?php echo $i; ?>" itemprop="keywords">
                    <a href="<?php echo Route::_(RouteHelper::getTagRoute($tag->tag_id . ':' . $tag->alias)); ?>" class="uk-link-reset uk-light <?php echo $link_class; ?>">
                        <?php echo $this->escape($tag->title); ?>
                    </a>
                </span>
                <?php
            }
        }
        ?>
    </div>
<?php
}
