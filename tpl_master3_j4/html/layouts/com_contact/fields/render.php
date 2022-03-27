<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   (C) 2016 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\Component\Fields\Administrator\Helper\FieldsHelper;

if (!array_key_exists('item', $displayData) || !array_key_exists('context', $displayData)) {
    return;
}

$item = $displayData['item'];

if (!$item) {
    return;
}

$context = $displayData['context'];

if (!$context) {
    return;
}

$parts     = explode('.', $context);
$component = $parts[0];
$fields    = null;

if (array_key_exists('fields', $displayData)) {
    $fields = $displayData['fields'];
} else {
    $fields = $item->jcfields ?: FieldsHelper::getFields($context, $item, true);
}

if (!$fields) {
    return;
}

$isMail = (reset($fields)->context == 'com_contact.mail');

if (!$isMail) {
    echo '<dl class="uk-description-list">';
}

foreach ($fields as $field) {
    if (!strlen($field->value) && !$isMail) {
        continue;
    }

    $layout = $field->params->get('layout', 'render');
    echo FieldsHelper::render($context, 'field.' . $layout, array('field' => $field));
}

if (!$isMail) {
    echo '</dl>';
}
