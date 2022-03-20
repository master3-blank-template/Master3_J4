<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.Master3_J4
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Helper\AuthenticationHelper;

$app = Factory::getContainer()->get(Joomla\CMS\Application\SiteApplication::class);
$twofactormethods = AuthenticationHelper::getTwoFactorMethods();

$favicon = $this->params->get('favicon');
$favicon = $favicon ?: 'templates/' . $app->getTemplate()->template . '/favicon.png';
$this->addFavicon(Uri::base(true) . '/' . $favicon, 'image/png', 'shortcut icon');

$faviconApple = $this->params->get('faviconApple');
$faviconApple = $faviconApple ?: 'templates/' . $app->getTemplate()->template . '/apple-touch-icon.png';
$this->addHeadLink(Uri::base(true) . '/' . $faviconApple, 'apple-touch-icon-precomposed');

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <jdoc:include type="head"/>
</head>
<body class="uk-flex uk-flex-middle uk-flex-center" style="min-height:100vh">
    <div class="uk-panel">
        <div class="uk-container" style="max-width:400px;">
            <div class="uk-flex uk-flex-column uk-flex-middle uk-text-center">

                <div class="uk-logo"><?php echo $config->getLogo(); ?></div>

                <?php if ($app->get('offline_image') && file_exists($app->get('offline_image'))) { ?>
                <img class="uk-margin-medium-top"
                    data-src="<?php echo $app->get('offline_image'); ?>"
                    alt="<?php echo $sitename; ?>"
                    data-uk-img loading="lazy"
                >
                <?php } ?>

                <?php
                if (
                    $app->get('display_offline_message', 1) == 1
                    && str_replace(' ', '', $app->get('offline_message')) !== ''
                ) {
                    ?>
                <p class="uk-margin-medium"><?php echo $app->get('offline_message'); ?></p>
                <?php } elseif ($app->get('display_offline_message', 1) == 2) { ?>
                <p class="uk-margin-medium"><?php echo Text::_('JOFFLINE_MESSAGE'); ?></p>
                <?php } ?>

            </div>

            <?php if ($this->params->get('offlineLoginForm')) { ?>
            <form action="<?php echo Route::_('index.php', true); ?>" method="post" id="form-login">

                <input class="uk-input uk-margin-top uk-text-center"
                    name="username"
                    type="text"
                    title="<?php echo Text::_('JGLOBAL_USERNAME'); ?>"
                    placeholder="<?php echo Text::_('JGLOBAL_USERNAME'); ?>"
                >

                <input class="uk-input uk-margin-top uk-text-center"
                    name="password"
                    type="password"
                    id="password"
                    title="<?php echo Text::_('JGLOBAL_PASSWORD'); ?>"
                    placeholder="<?php echo Text::_('JGLOBAL_PASSWORD'); ?>"
                >

                <?php if (count($twofactormethods) > 1) { ?>
                <input class="uk-input uk-margin-top"
                    name="secretkey"
                    type="text"
                    id="secretkey"
                    title="<?php echo Text::_('JGLOBAL_SECRETKEY'); ?>"
                    placeholder="<?php echo Text::_('JGLOBAL_SECRETKEY'); ?>"
                >
                <?php } ?>

                <button type="submit" name="Submit"
                    class="uk-button uk-button-primary uk-margin-top uk-width"
                ><?php echo Text::_('JLOGIN'); ?></button>

                <input type="hidden" name="option" value="com_users">
                <input type="hidden" name="task" value="user.login">
                <input type="hidden" name="return" value="<?php echo base64_encode(Uri::base()); ?>">
                <?php echo HTMLHelper::_('form.token'); ?>
            </form>
            <?php } ?>

        </div>
    </div>
</body>
</html>
