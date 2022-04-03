<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_fields
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

if (empty($fields)) {
    return;
}

$output = array();

foreach ($fields as $field) {
    if (!isset($field->value) || trim($field->value) === '') {
        continue;
    }

    $class = trim($field->name . ' ' . $field->params->get('render_class'));
    $layout = $field->params->get('layout', 'render');
    $content = FieldsHelper::render(
        $context,
        'field.' . $layout,
        array('field' => $field, 'class' => $class)
    );

    if (trim($content) === '') {
        continue;
    }

    $output[] = $content;
}

if (empty($output)) {
    return;
}
?>
<dl class="uk-description-list">
    <?php echo implode("\n", $output); ?>
</dl>
