<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.Master3_J4
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

\defined('_JEXEC') or die;

include_once(__DIR__ . '/config.php');

master3_setHead($this);

$cssGotoBottom = $this->params->get('cssGotoBottom');
$jsGotoBottom = $this->params->get('jsGotoBottom');

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">

<head>

    <jdoc:include type="metas" />
    <?php if (!$cssGotoBottom) { ?>
    <jdoc:include type="styles" />
    <?php } ?>
    <?php if (!$jsGotoBottom) { ?>
    <jdoc:include type="scripts" />
    <?php } ?>

</head>

<body>


    <?php
    /*
     * include layout
     * layout name === active menu item alias
     * if no layout is found for the active menu item, the default layout is used
     */
    include(realpath(__DIR__ . '/layouts/template.' . master3_getLayout($this->params) . '.php'));
    ?>


    <?php if ($cssGotoBottom) { ?>
    <jdoc:include type="styles" />
    <?php } ?>
    <?php if ($jsGotoBottom) { ?>
    <jdoc:include type="scripts" />
    <?php } ?>


</body>

</html>
