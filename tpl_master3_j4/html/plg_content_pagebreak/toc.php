<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  Content.pagebreak
 *
 * @copyright   (C) 2018 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;

?>
<div class="article-index">
    <div class="card-body">
        <?php if ($headingtext) { ?>
            <h3><?php echo $headingtext; ?></h3>
        <?php } ?>
        <ul class="uk-subnav">
            <?php foreach ($list as $listItem) { ?>
                <?php $class = $listItem->active ? ' active' : ''; ?>
                <li>
                    <a href="<?php echo Route::_($listItem->link); ?>" class="toclink<?php echo $class; ?>">
                        <?php echo $listItem->title; ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
