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

if (!array_key_exists('field', $displayData)) {
    return;
}

$field = $displayData['field'];
$class = $displayData['class'];
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

?>
<?php if ($showLabel == 1) { ?>
    <dt class="field-label <?php echo $labelClass; ?>"><?php echo htmlentities($label, ENT_QUOTES | ENT_IGNORE, 'UTF-8'); ?>: </dt>
<?php } ?>
<dd class="field-value <?php echo $valueClass; ?>">
    <?php if ($prefix) { ?>
        <span class="field-prefix"><?php echo htmlentities($prefix, ENT_QUOTES | ENT_IGNORE, 'UTF-8'); ?></span>
    <?php } ?>
    <span><?php echo $value; ?></span>
    <?php if ($suffix) { ?>
        <span class="field-suffix"><?php echo htmlentities($suffix, ENT_QUOTES | ENT_IGNORE, 'UTF-8'); ?></span>
    <?php } ?>
</dd>
