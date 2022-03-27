<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_breadcrumbs
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

echo '<ul class="uk-breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList" aria-label="' .
    htmlspecialchars($module->title, ENT_QUOTES, 'UTF-8') . '">';

if (!$params->get('showLast', 1)) {
    array_pop($list);
}

$count = count($list);
$linkCurrent = Uri::current();
$linkRoot = substr(Uri::root(), 0, -1);

for ($i = 0; $i < $count; $i++) {
    if ($i == 1 && !empty($list[$i]->link) && !empty($list[$i - 1]->link) && $list[$i]->link == $list[$i - 1]->link) {
        continue;
    }

    if ($pos = strpos($list[$i]->name, '||')) {
        $name = trim(substr($list[$i]->name, 0, $pos));
    } else {
        $name = $list[$i]->name;
    }

    $meta = '<meta itemprop="position" content="' . ($i + 1) . '">';

    if ($i < $count - 1) {
        if (!empty($list[$i]->link)) {
            $link = Route::_($list[$i]->link, true, Route::TLS_IGNORE, true);
            $link = explode('?', $link)[0];
            echo '<li itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a itemprop="item" content="' . $linkRoot . $link . '" href="' . $link . '"><span itemprop="name">' . $name . '</span></a>' . $meta . '</li>';
        } else {
            echo '<li itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem"><span itemprop="item" content="' . $linkRoot . '"><span itemprop="name">' . $name . '</span></span>' . $meta . '</li>';
        }
    } else {
        echo '<li itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem"><span itemprop="item" content="' . $linkCurrent . '"><span itemprop="name">' . $name . '</span></span>' . $meta . '</li>';
    }
}

echo '</ul>';

// Structured data as JSON
$data = [
    '@context'        => 'https://schema.org',
    '@type'           => 'BreadcrumbList',
    'itemListElement' => []
];

foreach ($list as $key => $item) {
    $data['itemListElement'][] = [
        '@type'    => 'ListItem',
        'position' => $key + 1,
        'item'     => [
            '@id'  => $item->link ? Route::_($item->link, true, Route::TLS_IGNORE, true) : Route::_(Uri::getInstance()),
            'name' => $item->name
        ]
    ];
}

$wa = $app->getDocument()->getWebAssetManager();
$wa->addInline('script', json_encode($data, JSON_UNESCAPED_UNICODE), [], ['type' => 'application/ld+json']);
