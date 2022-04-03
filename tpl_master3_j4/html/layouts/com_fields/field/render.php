<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_fields
 *
 * @copyright   (C) 2016 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

if (!array_key_exists('field', $displayData)) {
    return;
}

$field = $displayData['field'];
$class = $displayData['class'] ?? '';
$label = Text::_($field->label);
$value = $field->value;
$showLabel = $field->params->get('showlabel');
$prefix = Text::plural($field->params->get('prefix'), $value);
$suffix = Text::plural($field->params->get('suffix'), $value);
$labelClass = trim($class . ' ' . $field->params->get('label_render_class'));
$valueClass = trim($class . ' ' . $field->params->get('value_render_class'));

if ($value == '') {
    return;
}

if ($showLabel == 1) {
    echo '<dt class="field-label ' . $labelClass . '">' . htmlentities($label, ENT_QUOTES | ENT_IGNORE, 'UTF-8') . ': </dt>';
}

if ($field->type == 'media') {
    echo '<figure class="uk-width">';
    $layoutAttr = [
        'src'      => $field->rawvalue['imagefile'],
        'itemprop' => 'image',
        'alt'      => empty($images->image_fulltext_alt) && empty($images->image_fulltext_alt_empty) ? false : $images->image_fulltext_alt,
        'width'    => '100%'
    ];
    echo LayoutHelper::render('joomla.html.image', $layoutAttr);
    if ($field->rawvalue['alt_text'] !== '') {
        echo '<figcaption class="caption">' . $this->escape($field->rawvalue['alt_text']) . '</figcaption>';
    }
    echo '</figure>';
} else {
    echo '<dd class="field-value ' .  $valueClass . '">';
    if ($prefix) {
        echo '<span class="field-prefix">' . htmlentities($prefix, ENT_QUOTES | ENT_IGNORE, 'UTF-8') . '</span>';
    }
    echo '<span>' .  $value . '</span>';
    if ($suffix) {
        echo '<span class="field-suffix">' . htmlentities($suffix, ENT_QUOTES | ENT_IGNORE, 'UTF-8') . '</span>';
    }
    echo '</dd>';
}
