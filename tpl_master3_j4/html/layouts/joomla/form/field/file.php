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
use Joomla\CMS\Utility\Utility;

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   string   $autocomplete    Autocomplete attribute for the field.
 * @var   boolean  $autofocus       Is autofocus enabled?
 * @var   string   $class           Classes for the input.
 * @var   string   $description     Description of the field.
 * @var   boolean  $disabled        Is this field disabled?
 * @var   string   $group           Group the field belongs to. <fields> section in form XML.
 * @var   boolean  $hidden          Is this field hidden in the form?
 * @var   string   $hint            Placeholder for the field.
 * @var   string   $id              DOM id of the field.
 * @var   string   $label           Label of the field.
 * @var   string   $labelclass      Classes to apply to the label.
 * @var   boolean  $multiple        Does this field support multiple values?
 * @var   string   $name            Name of the input field.
 * @var   string   $onchange        Onchange attribute for the field.
 * @var   string   $onclick         Onclick attribute for the field.
 * @var   string   $pattern         Pattern (Reg Ex) of value of the form field.
 * @var   boolean  $readonly        Is this field read only?
 * @var   boolean  $repeat          Allows extensions to duplicate elements.
 * @var   boolean  $required        Is this field required?
 * @var   integer  $size            Size attribute of the input.
 * @var   boolean  $spellcheck      Spellcheck state for the form field.
 * @var   string   $validate        Validation rules to apply.
 * @var   string   $value           Value attribute of the field.
 * @var   array    $checkedOptions  Options that will be set as checked.
 * @var   boolean  $hasValue        Has this field a value assigned?
 * @var   array    $options         Options available for this field.
 * @var   array    $inputType       Options available for this field.
 * @var   string   $accept          File types that are accepted.
 * @var   string   $dataAttribute   Miscellaneous data attributes preprocessed for HTML output
 * @var   array    $dataAttributes  Miscellaneous data attribute for eg, data-*
 */

$app = Factory::getContainer()->get(Joomla\CMS\Application\SiteApplication::class);
$jsIcons = $app->getTemplate(true)->params->get('jsIcons', 'none') != 'none';

$maxSize = HTMLHelper::_('number.bytes', Utility::getMaxUploadSize());

?>
<div class="uk-button-group">
    <div data-uk-form-custom="target: true">
        <input type="file" name="<?php echo $name; ?>" id="<?php echo $id; ?>"
            <?php echo !empty($size) ? ' size="' . $size . '"' : ''; ?>
            <?php echo !empty($accept) ? ' accept="' . $accept . '"' : ''; ?>
            <?php echo !empty($class) ? ' class="' . $class . '"' : ''; ?>
            <?php echo !empty($multiple) ? ' multiple' : ''; ?>
            <?php echo $dataAttribute; ?>
            <?php echo !empty($onchange) ? ' onchange="' . $onchange . '"' : ''; ?>
            <?php echo $required ? ' required' : ''; ?>>

        <input class="uk-input uk-form-width-medium" type="text" placeholder="<?php echo Text::sprintf('JGLOBAL_MAXIMUM_UPLOAD_SIZE_LIMIT', $maxSize); ?>" disabled>
    </div>
    <button class="uk-button uk-button-default"<?php echo $disabled ? ' disabled' : ''; ?>>
        <?php if ($jsIcons) { ?>
        <span data-uk-icon="icon:file" aria-hidden="true" style="min-width:20px;"></span>
        <span class="visually-hidden uk-hidden"><?php echo Text::_('JLIB_FORM_VALUE_CACHE_FILE'); ?></span>
        <?php } else { ?>
        <span><?php echo Text::_('JLIB_FORM_VALUE_CACHE_FILE'); ?></span>
        <?php } ?>
    </button>
</div>
