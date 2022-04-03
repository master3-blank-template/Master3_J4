<?php

/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   (C) 2013 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

?>
<div class="toggle-editor btn-toolbar float-end clearfix mt-3">
    <div class="btn-group">
        <button type="button" disabled class="uk-button uk-button-link js-tiny-toggler-button">
            <?php echo Text::_('PLG_TINY_BUTTON_TOGGLE_EDITOR'); ?>
        </button>
    </div>
</div>
