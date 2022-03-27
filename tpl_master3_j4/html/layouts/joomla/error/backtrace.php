<?php

/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   (C) 2017 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

/** @var $displayData array */
$backtraceList = $displayData['backtrace'];

if (!$backtraceList) {
    return;
}

$class = $displayData['class'] ?? 'uk-table uk-table-striped uk-table-hover';
?>
<h3>Call stack</h3>
<table class="<?php echo $class; ?>">
    <thead>
        <tr>
            <th>#</th>
            <th>Function</th>
            <th>Location</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($backtraceList as $k => $backtrace) { ?>
        <tr>
            <td><?php echo $k + 1; ?></td>

            <?php if (isset($backtrace['class'])) { ?>
                <td><?php echo $backtrace['class'] . $backtrace['type'] . $backtrace['function'] . '()'; ?></td>
            <?php } else { ?>
                <td><?php echo $backtrace['function'] . '()'; ?></td>
            <?php } ?>

            <?php if (isset($backtrace['file'])) { ?>
                <td><?php echo HTMLHelper::_('debug.xdebuglink', $backtrace['file'], $backtrace['line']); ?></td>
            <?php } else { ?>
                <td>&#160;</td>
            <?php } ?>
        </tr>
    <?php } ?>
    </tbody>
</table>
