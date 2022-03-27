<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_custom
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;

$modId = 'tm-modid-' . $module->id;

if ($params->get('backgroundimage')) {
	$wa = $app->getDocument()->getWebAssetManager();
	$wa->addInlineStyle(
        '#' . $modId . '{background-image: url("' . Uri::root(true) . '/' .
            HTMLHelper::_('cleanImageURL', $params->get('backgroundimage'))->url . '");}' . "\n",
        ['name' => $modId]
    );
}

?>

<div id="<?php echo $modId; ?>" class="mod-custom custom">
	<?php echo $module->content; ?>
</div>
