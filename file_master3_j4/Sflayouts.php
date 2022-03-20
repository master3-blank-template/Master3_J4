<?php

/**
 * @package     Joomla.Platform
 * @subpackage  Form
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Joomla\CMS\Form\Field;

\defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\Form\Field\SubformField;
use Joomla\Registry\Registry;

class SflayoutsField extends SubformField
{
    protected $type = 'sflayouts';

    public function setup(\SimpleXMLElement $element, $value, $group = null)
    {
        if (!parent::setup($element, $value, $group)) {
            return false;
        }

        $formParams = new Registry($this->form->getData());
        $templateName = $formParams->get('template');

        $fields = $this->getFields($element->form->fieldset);
        $files = $this->getFiles($templateName);

        $outValues = [];

        foreach ($files as $key => $file) {
            $originRow = '';

            if ($this->value) {
                foreach ($this->value as $originValue) {
                    if ($originValue['name'] == $file) {
                        $originRow = $originValue;
                    }
                }
            } else {
                $originRow = [
                    'name' => '',
                    'menuassign' => false
                ];
            }

            foreach ($fields as $field) {
                $fieldValue = '';

                if ($field === 'name') {
                    $fieldValue = $file;
                } elseif ($originRow && $originRow['name'] === $file) {
                    $fieldValue = isset($originRow[$field]) ? $originRow[$field] : null;
                }

                if ($fieldValue !== null) {
                    $outValues[$this->fieldname . $key][$field] = $fieldValue;
                }
            }
        }

        $this->layout = 'joomla.form.field.subform.repeatable-table';

        $this->groupByFieldset = false;

        $this->value = $outValues;

        return true;
    }

    protected function getFields($form)
    {
        $fields = [];
        foreach ($form as $field) {
            foreach ($field as $item) {
                $fields[] = $item->attributes()->name->__toString();
            }
        }
        return $fields;
    }

    protected function getFiles($templateName)
    {
        $files = [];

        $filePath = realpath(Path::clean(JPATH_ROOT . "/templates/{$templateName}/layouts"));

        $list = glob($filePath . DIRECTORY_SEPARATOR . 'template.*.php');

        if (is_array($list)) {
            foreach ($list as $listItem) {
                $tmp = strtolower(str_replace('template.', '', basename($listItem, '.php')));
                if (
                    !in_array(
                        $tmp,
                        ['default', 'default-original', 'error', 'error-original', 'offline', 'offline-original']
                    )
                ) {
                    $files[] = $tmp;
                }
            }
        }

        return $files;
    }
}
