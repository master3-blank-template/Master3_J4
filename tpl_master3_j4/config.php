<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.Master3_J4
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Helper\ModuleHelper;

function master3_getTemplateName()
{
    $template = Joomla\CMS\Factory::getContainer()
        ->get(Joomla\CMS\Application\SiteApplication::class)
        ->getTemplate(true)
        ->template;

    return $template;
}

function master3_getMenuItemActiveId()
{
    $app = Factory::getContainer()->get(Joomla\CMS\Application\SiteApplication::class);

    $menuItem = $app->getMenu('site')->getActive();
    $menuDefault = $app->getMenu('site')->getDefault();

    return isset($menuItem) ? $menuItem->id : $menuDefault->id;
}

function master3_getLayout($params)
{
    $layouts = $params->get('templateLayouts', []);
    $layout = 'default';

    $templateName = master3_getTemplateName();
    $menuActiveId = master3_getMenuItemActiveId();

    foreach ($layouts as $name => $items) {
        if (in_array($menuActiveId, $items)) {
            $layout = $name;
            break;
        }
    }

    if (!file_exists(realpath(JPATH_ROOT . "/templates/{$templateName}/layouts/template.{$layout}.php"))) {
        $layout = 'default';
    }
    if (!file_exists(realpath(JPATH_ROOT . "/templates/{$templateName}/layouts/template.{$layout}.php"))) {
        $layout = 'default-original';
    }

    return $layout;
}

function master3_getSystemOutput()
{
    $app = Factory::getContainer()->get(Joomla\CMS\Application\SiteApplication::class);
    $doc = $app->getDocument();

    $out = $doc->getBuffer('component');

    $clean = $out;
    $clean = htmlspecialchars(strip_tags($clean));
    $clean = trim(str_replace(["\t", "\n", "\r"], '', $clean));

    return $clean ? $out : '';
}

function master3_setHead($template)
{
    $templateName = master3_getTemplateName();

    $template->setHtml5(true);
    $template->setGenerator('');
    $template->setMetaData('viewport', 'width=device-width,initial-scale=1');
    $template->setMetaData('X-UA-Compatible', 'IE=edge', 'http-equiv');

    // include UIkit css
    $cssUikit = $template->params->get('cssUikit', 'uikit.min.css');
    if ($cssUikit !== 'none') {
        $isRTL = strpos($cssUikit, 'rtl') !== false;
        $isMin = strpos($cssUikit, 'min') !== false;
        HTMLHelper::_('uikit3.css', $isRTL, $isMin);
    }

    // include jQuery
    if ($template->params->get('jsJQ', false)) {
        HTMLHelper::_('jquery.framework', true, null, false);
    }

    // inclide UIkit js
    $jsUikit = $template->params->get('jsUikit', 'uikit.min.js');
    if ($jsUikit !== 'none') {
        $isMin = strpos($jsUikit, 'min') !== false;
        HTMLHelper::_('uikit3.js', $isMin);
    }

    // include UIkit icons js
    $jsIcons = $template->params->get('jsIcons', 'uikit-icons.min.js');
    if ($jsIcons !== 'none') {
        $isMin = strpos($jsIcons, 'min') !== false;
        HTMLHelper::_('uikit3.icons', $isMin);
    }

    // include browser's icons
    $template->addFavicon(
        Uri::base(true) . '/templates/' . $templateName . '/favicon.png',
        'image/png',
        'shortcut icon'
    );
    $template->addHeadLink(
        Uri::base(true) . '/templates/' . $templateName . '/apple-touch-icon.png',
        'apple-touch-icon-precomposed'
    );
}

function master3_getMime($file)
{
    if (function_exists('mime_content_type')) {
        return mime_content_type($file);
    } else {
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        switch ($ext) {
            case 'png':
                $mime = 'image/png';
                break;

            case 'jpeg':
            case 'jpe':
            case 'jpg':
                $mime = 'image/jpeg';
                break;

            case 'gif':
                $mime = 'image/gif';
                break;

            case 'svg':
                $mime = 'image/svg+xml';
                break;
            case 'svgz':
                $mime = 'image/svg';
                break;

            case 'tiff':
            case 'tif':
                $mime = 'image/tiff';
                break;

            case 'ico':
                $mime = 'image/vnd.microsoft.icon';
                break;

            default:
                $mime = '';
        }
        return $mime;
    }
}


function master3_getLogo($params)
{
    $app = Factory::getContainer()->get(Joomla\CMS\Application\SiteApplication::class);
    $doc = $app->getDocument();

    $link = Route::_('index.php?Itemid=' . $app->getMenu('site')->getDefault()->id);

    $isMain = (Uri::current() == Uri::base()) ||
        (Uri::current() == Uri::base() . substr($link, strlen(Uri::base(true)) + 1));

    $mainHref = Route::_('index.php?Itemid=' . $app->getMenu('site')->getDefault()->id);

    $logotag = $isMain ? 'div' : 'a';
    $logohref = $isMain ? '' : ' href="' . $mainHref . '"';
    $out = '';

    if ($doc->countModules('logo')) {
        $out .= "<{$logotag}{$logohref} class=\"uk-logo uk-flex-inline\">";
        $out .= '<jdoc:include type="modules" name="logo" style="empty" />';
        $out .= "</{$logotag}>";
    } else {
        $logoFile = $params->get('logoFile', '');
        $siteTitle = $params->get('siteTitle', '');

        if ($logoFile || $siteTitle) {
            $out .= "<{$logotag}{$logohref} class=\"uk-logo uk-flex-inline uk-flex-middle\">";

            if ($logoFile) {
                $mime = master3_getMime(Path::clean(JPATH_BASE . '/' . $logoFile));
                if ($mime == 'image/svg' || $mime == 'image/svg+xml') {
                    $out .= file_get_contents(Path::clean(JPATH_BASE . '/' . $logoFile));
                } else {
                    $out .= "<img src=\"{$logoFile}\" alt=\"{$siteTitle}\" loading=\"lazy\">";
                }
            }

            if ($siteTitle) {
                $out .= '<span' .
                    ($logoFile ? ' class="uk-display-inline-block uk-margin-small-left"' : '')
                    . '>' . $siteTitle . '</span>';
            }

            $out .= "</{$logotag}>";
        } else {
            $out = '';
        }
    }

    return $out;
}

function master3_getNavbarMode()
{
    $app = Factory::getContainer()->get(Joomla\CMS\Application\SiteApplication::class);
    $doc = $app->getDocument();

    $obj = new \stdClass();
    $isOffcanvas = $doc->countModules('offcanvas') > 0 || $doc->countModules('offcanvas-menu') > 0;

    $isNavbarMenu = false;
    foreach (ModuleHelper::getModules('navbar-left') as $module) {
        if ($module->module === 'mod_menu') {
            $isNavbarMenu = true;
            break;
        }
    }
    $obj->left = $isNavbarMenu && $isOffcanvas;

    // ckeck menu in 'navbar-center' position
    if (!$isNavbarMenu) {
        foreach (ModuleHelper::getModules('navbar-center') as $module) {
            if ($module->module === 'mod_menu') {
                $isNavbarMenu = true;
                break;
            }
        }
        $obj->center = $isNavbarMenu && $isOffcanvas;
    } else {
        $obj->center = false;
    }

    // ckeck menu in 'navbar-right' position
    if (!$isNavbarMenu) {
        foreach (ModuleHelper::getModules('navbar-right') as $module) {
            if ($module->module === 'mod_menu') {
                $isNavbarMenu = true;
                break;
            }
        }
        $obj->right = $isNavbarMenu && $isOffcanvas;
    } else {
        $obj->right = false;
    }

    return $obj;
}
