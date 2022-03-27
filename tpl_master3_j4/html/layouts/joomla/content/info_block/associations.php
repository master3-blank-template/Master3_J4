<?php

/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   (C) 2016 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Filesystem\Path;

$app          = Factory::getContainer()->get(Joomla\CMS\Application\SiteApplication::class);
$templateName = $app->getTemplate(true)->template;
$jsIcons      = $app->getTemplate(true)->params->get('jsIcons', 'none') != 'none';

?>

<?php
if (!empty($displayData['item']->associations)) {
    $associations = $displayData['item']->associations;
    ?>
    <dd class="uk-flex uk-flex-middle association">
        <?php
        if ($jsIcons) {
            echo '<span data-uk-icon="icon:world" aria-hidden="true"></span>%nbsp;';
        }
        echo  '<span>' . Text::_('JASSOCIATIONS');
        foreach ($associations as $association) {
            if ($displayData['item']->params->get('flags', 1) && $association['language']->image) {
                $lang_image = realpath(Path::clean(JPATH_ROOT . '/templates/' . $templateName . '/html/mod_languages/images/' .  $association['language']->image . '.svg'));
                if ($lang_image) {
                    $flag = '<span class="uk-border-circle uk-flex-inline" style="width:1em;">' . file_get_contents($lang_image) . '</span>';
                } else {
                    $flag = HTMLHelper::_('image', 'mod_languages/' . $association['language']->image . '.gif', '', array('class' => 'me-1'), true) . htmlspecialchars($association['language']->title_native, ENT_COMPAT, 'UTF-8');
                }
            ?>
                <a class="uk-link uk-link-reset" href="<?php echo Route::_($association['item']); ?>"><?php echo $flag; ?></a>
            <?php } else { ?>
                <?php $class = 'uk-link uk-link-reset btn-' . strtolower($association['language']->lang_code); ?>
                <a class="<?php echo $class; ?>" title="<?php echo $association['language']->title_native; ?>" href="<?php echo Route::_($association['item']); ?>"><?php echo $association['language']->lang_code; ?></a>
            <?php
            }
        }
        echo '</span>';
        ?>
    </dd>
<?php
}
