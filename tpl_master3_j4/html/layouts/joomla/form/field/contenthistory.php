<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   (C) 2015 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

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
 * @var   boolean  $spellcheck       Spellcheck state for the form field.
 * @var   string   $validate        Validation rules to apply.
 * @var   string   $value           Value attribute of the field.
 * @var   array    $checkedOptions  Options that will be set as checked.
 * @var   boolean  $hasValue        Has this field a value assigned?
 * @var   array    $options         Options available for this field.
 * @var   string   $link            The link for the content history page
 * @var   string   $label           The label text
 * @var   string   $dataAttribute   Miscellaneous data attributes preprocessed for HTML output
 * @var   array    $dataAttributes  Miscellaneous data attributes for eg, data-*.
 */

$app = Factory::getContainer()->get(Joomla\CMS\Application\SiteApplication::class);
$jsIcons = $app->getTemplate(true)->params->get('jsIcons', 'none') != 'none';

$onclick = 'onclick="this.closest(\'.uk-open\').classList.remove(\'uk-open\', \'uk-flex\');document.documentElement.classList.remove(\'uk-modal-page\')"';

echo HTMLHelper::_(
	'bootstrap.renderModal',
	'versionsModal',
	[
		'url'    => Route::_($link),
		'title'  => $label,
        'closeButton' => false,
		'height' => '100%',
		'width'  => '100%',
		'modalWidth'  => '80',
		'bodyHeight'  => '60',
		'footer' => '<button type="button" class="uk-button uk-button-primary" data-bs-dismiss="modal" aria-hidden="true" ' . $onclick . '>'
			. Text::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</button>'
    ]
);

?>
<button
	type="button"
	class="uk-button uk-button-primary"
	data-bs-toggle="modal"
	data-bs-target="#versionsModal"
    data-uk-toggle="target:#<?php echo 'versionsModal'; ?>"
	<?php echo $dataAttribute; ?>>
    <?php if ($jsIcons) { ?>
        <span data-uk-icon="icon:list" aria-hidden="true" style="min-width:20px;"></span>
        <span class="visually-hidden uk-hidden"><?php echo $label; ?></span>
        <?php } else { ?>
        <span><?php echo $label; ?></span>
        <?php } ?>
</button>
