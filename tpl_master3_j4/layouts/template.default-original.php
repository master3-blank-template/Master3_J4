<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.Master3_J4
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

$sectionClass = 'uk-section uk-section-default';
$containerClass = 'uk-container';

?>


<?php
/*
 * toolbar-left
 * toolbar-right
 */
if ($this->countModules('toolbar-left') || $this->countModules('toolbar-right')) {
    ?>
<div role="toolbar" id="section-toolbar" class="uk-section uk-section-small">
    <div class="<?php echo $containerClass; ?>">
        <div class="uk-flex uk-flex-middle uk-flex-between">

            <?php if ($this->countModules('toolbar-left')) { ?>
            <jdoc:include type="modules" name="toolbar-left" style="master3" />
            <?php } ?>

            <?php if ($this->countModules('toolbar-right')) { ?>
            <jdoc:include type="modules" name="toolbar-right" style="master3" />
            <?php } ?>

        </div>
    </div>
</div>
<?php } ?>


<?php
/*
 * logo
 * headbar
 */
$logo = master3_getLogo($this->params);
if ($this->countModules('headbar') || $logo !== '') {
    ?>
<header id="section-headbar" class="uk-section uk-section-small">
    <div class="<?php echo $containerClass; ?>">
        <div data-uk-grid>

            <?php if ($logo !== '') { ?>
            <div class="uk-width-auto@m uk-flex uk-flex-middle">
                <?php echo $logo; ?>
            </div>
            <?php } ?>

            <?php if ($this->countModules('headbar')) { ?>
            <div class="uk-width-expand@m uk-flex uk-flex-middle uk-flex-right@m">
                <jdoc:include type="modules" name="headbar" style="master3" />
            </div>
            <?php } ?>

        </div>
    </div>
</header>
<?php } ?>


<?php
/*
 * navbar-left
 * navbar-center
 * navbar-right
 */
if (
    $this->countModules('navbar-left')
    || $this->countModules('navbar-center')
    || $this->countModules('navbar-right')
) {
    $navbarMenuMode = master3_getNavbarMode();
    $menuResponsive = '@m';
    ?>
<div role="navigation" id="navbar" class="uk-section uk-padding-remove-vertical uk-navbar-container">
    <div class="<?php echo $containerClass; ?>">
        <div data-uk-navbar>

            <?php
            if ($this->countModules('navbar-left')) {
                if ($navbarMenuMode->left) {
                    ?>
            <div class="uk-navbar-left uk-hidden<?php echo $menuResponsive; ?>">
                <a href="#offcanvas-menu" class="uk-navbar-toggle"
                    data-uk-navbar-toggle-icon data-uk-toggle aria-label="Menu"></a>
            </div>
                <?php } ?>
            <div class="uk-navbar-left<?php echo ($navbarMenuMode->left ? ' uk-visible' . $menuResponsive : ''); ?>">
                <jdoc:include type="modules" name="navbar-left" style="<?php echo $navbarMenuMode->leftStyle; ?>" />
            </div>
            <?php } ?>

            <?php
            if ($this->countModules('navbar-center')) {
                if ($navbarMenuMode->center) {
                    ?>
            <div class="uk-navbar-center uk-hidden<?php echo $menuResponsive; ?>">
                <a href="#offcanvas-menu" class="uk-navbar-toggle"
                    data-uk-navbar-toggle-icon data-uk-toggle aria-label="Menu"></a>
            </div>
                <?php } ?>
            <div class="uk-navbar-center<?php echo ($navbarMenuMode->center
                ? ' uk-visible' . $menuResponsive : ''); ?>"
            >
                <jdoc:include type="modules" name="navbar-center" style="<?php echo $navbarMenuMode->centerStyle; ?>" />
            </div>
            <?php } ?>

            <?php
            if ($this->countModules('navbar-right')) {
                if ($navbarMenuMode->right) {
                    ?>
            <div class="uk-navbar-right uk-hidden<?php echo $menuResponsive; ?>">
                <a href="#offcanvas-menu" class="uk-navbar-toggle"
                    data-uk-navbar-toggle-icon data-uk-toggle aria-label="Menu"></a>
            </div>
                <?php } ?>
            <div class="uk-navbar-right<?php echo ($navbarMenuMode->right
                ? ' uk-visible' . $menuResponsive : ''); ?>"
            >
                <jdoc:include type="modules" name="navbar-right" style="<?php echo $navbarMenuMode->rightStyle; ?>" />
            </div>
            <?php } ?>

        </div>
    </div>
</div>
<?php } ?>


<?php
/*
 * block-[a-e]
 */
$blockSections = ['block-a', 'block-b', 'block-c', 'block-d', 'block-e'];
$blockSectionsSfx = [];
$blockSectionsSfxLast = '';
foreach (array_reverse($blockSections) as $block) {
    if ($this->countModules($block)) {
        $blockSectionsSfxLast = $blockSectionsSfxLast ? '' : ' uk-section-muted';
        $blockSectionsSfx[$block] = $blockSectionsSfxLast;
    }
}
foreach ($blockSections as $blockSection) {
    if ($sectionPosCount = $this->countModules($blockSection)) {
        $sectionPosCount = $sectionPosCount > 6 ? 6 : $sectionPosCount;
        $sectionGridClass = 'uk-child-width-1-' . $sectionPosCount . '@m';
        ?>
<section id="section-<?php echo $blockSection; ?>" class="<?php echo $sectionClass . $blockSectionsSfx[$blockSection]; ?>">
    <div class="<?php echo $containerClass; ?>">
        <div class="<?php echo $sectionGridClass; ?>" data-uk-grid>
            <jdoc:include type="modules" name="<?php echo $blockSection; ?>" style="master3" />
        </div>
    </div>
</section>
        <?php
    }
}
?>


<?php
/*
 * breadcrumb
 */
if ($this->countModules('breadcrumb')) {
    ?>
<div role="navigation" id="section-breadcrumb" class="uk-section uk-section-xsmall">
    <div class="<?php echo $containerClass; ?>">
        <jdoc:include type="modules" name="breadcrumb" style="empty" />
    </div>
</div>
<?php } ?>


<?php
/*
 * system messages
 */
?>
<jdoc:include type="message" />


<?php
/*
 * system output
 * main-top
 * main-bottom
 * sidebar-a
 * sidebar-b
 */
$systemOutput = master3_getSystemOutput();
$countMainTop = $this->countModules('main-top');
$countMainBottom = $this->countModules('main-bottom');
$countSidebarA = $this->countModules('sidebar-a');
$countSidebarB = $this->countModules('sidebar-b');
if ($systemOutput || $countMainTop || $countMainBottom || $countSidebarA || $countSidebarB) {
    ?>
<div id="section-main" class="<?php echo $sectionClass; ?>">
    <div class="<?php echo $containerClass; ?>">
        <div data-uk-grid>
            <?php
            $responsive = '@m';
            $sidebarGridSize = '1-5';
            if ($systemOutput || $countMainTop || $countMainBottom) {
                if (($countSidebarA && !$countSidebarB) || (!$countSidebarA && $countSidebarB)) {
                    $mainGridSize = '4-5';
                } elseif ($countSidebarA && $countSidebarB) {
                    $mainGridSize = '3-5';
                } else {
                    $mainGridSize = '1-1';
                    $responsive = '';
                }
                ?>
            <div class="uk-width-<?php echo $mainGridSize . $responsive; ?>">
                <div class="uk-child-width-1-1" data-uk-grid>

                    <?php if ($countMainTop) { ?>
                    <div>
                        <div class="uk-child-width-1-1" data-uk-grid>
                            <jdoc:include type="modules" name="main-top" style="master3" />
                        </div>
                    </div>
                    <?php } ?>

                    <?php if ($systemOutput) { ?>
                    <div>
                        <main id="content">
                            <?php echo $systemOutput; ?>
                        </main>
                    </div>
                    <?php } ?>

                    <?php if ($countMainBottom) { ?>
                    <div>
                        <div class="uk-child-width-1-1" data-uk-grid>
                            <jdoc:include type="modules" name="main-bottom" style="master3" />
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
                <?php
            } else {
                if (($countSidebarA && !$countSidebarB) || (!$countSidebarA && $countSidebarB)) {
                    $sidebarGridSize = '1-1';
                    $responsive = '';
                } elseif ($countSidebarA && $countSidebarB) {
                    $sidebarGridSize = '1-2';
                }
            }
            ?>

            <?php if ($countSidebarA) { ?>
            <aside class="uk-width-<?php echo $sidebarGridSize . $responsive; ?> uk-flex-first">
                <div class="uk-child-width-1-1" data-uk-grid>
                    <jdoc:include type="modules" name="sidebar-a" style="master3" />
                </div>
            </aside>
            <?php } ?>

            <?php if ($countSidebarB) { ?>
            <aside class="uk-width-<?php echo $sidebarGridSize . $responsive; ?>">
                <div class="uk-child-width-1-1" data-uk-grid>
                    <jdoc:include type="modules" name="sidebar-b" style="master3" />
                </div>
            </aside>
            <?php } ?>
        </div>
    </div>
</div>
<?php } ?>


<?php
/*
 * block-[f-k]
 */
$blockSections = ['block-f', 'block-g', 'block-h', 'block-i', 'block-k'];
$blockSectionsSfxLast = '';
foreach ($blockSections as $blockSection) {
    if ($sectionPosCount = $this->countModules($blockSection)) {
        $sectionPosCount = $sectionPosCount > 6 ? 6 : $sectionPosCount;
        $sectionGridClass = 'uk-child-width-1-' . $sectionPosCount . '@m';
        $blockSectionsSfxLast = $blockSectionsSfxLast ? '' : ' uk-section-muted';
        ?>
<section id="section-<?php echo $blockSection; ?>" class="<?php echo $sectionClass . $blockSectionsSfxLast; ?>">
    <div class="<?php echo $containerClass; ?>">
        <div class="<?php echo $sectionGridClass; ?>" data-uk-grid>
            <jdoc:include type="modules" name="<?php echo $blockSection; ?>" style="master3" />
        </div>
    </div>
</section>
        <?php
    }
}
?>


<?php
/*
 * footer-left
 * footer-center
 * footer-right
 */
if (
    $this->countModules('footer-left')
    || $this->countModules('footer-center')
    || $this->countModules('footer-right')
) {
    $sectionPosCount =
        ($this->countModules('footer-left') ? 1 : 0)
        + ($this->countModules('footer-center') ? 1 : 0)
        + ($this->countModules('footer-right') ? 1 : 0);
    $sectionGridClass = 'uk-child-width-1-' . $sectionPosCount . '@m';
    ?>
<footer id="section-footer" class="uk-section uk-section-secondary uk-section-small">
    <div class="<?php echo $containerClass; ?>">
        <div class="<?php echo $sectionGridClass; ?>" data-uk-grid>

            <?php if ($this->countModules('footer-left')) { ?>
            <div>
                <jdoc:include type="modules" name="footer-left" style="master3" />
            </div>
            <?php } ?>

            <?php if ($this->countModules('footer-center')) { ?>
            <div>
                <jdoc:include type="modules" name="footer-center" style="master3" />
            </div>
            <?php } ?>

            <?php if ($this->countModules('footer-right')) { ?>
            <div>
                <jdoc:include type="modules" name="footer-right" style="master3" />
            </div>
            <?php } ?>

        </div>
    </div>
</footer>
<?php } ?>


<?php
/*
 * to-top scroller
 */
if ($this->params->get('totop')) { ?>
<a class="uk-padding-small uk-position-bottom-left uk-position-fixed" data-uk-totop data-uk-scroll aria-label="Up"></a>
<?php } ?>


<?php
/*
 * offcanvas
 */
if ($this->countModules('offcanvas')) {
    ?>
<aside id="offcanvas" data-uk-offcanvas="mode:slide;overlay:true">
    <div class="uk-offcanvas-bar">
        <a class="uk-offcanvas-close" data-uk-close aria-label="<?php echo Text::_('JLIB_HTML_BEHAVIOR_CLOSE'); ?>"></a>
        <jdoc:include type="modules" name="offcanvas" style="master3" />
    </div>
</aside>
<?php } ?>


<?php
/*
 * offcanvas-menu
 */
if ($this->countModules('offcanvas-menu')) {
    ?>
<aside id="offcanvas-menu" data-uk-offcanvas="mode:slide;overlay:true">
    <div class="uk-offcanvas-bar">
        <a class="uk-offcanvas-close" data-uk-close aria-label="<?php echo Text::_('JLIB_HTML_BEHAVIOR_CLOSE'); ?>"></a>
        <jdoc:include type="modules" name="offcanvas-menu" style="master3" />
    </div>
</aside>
<?php } ?>


<?php
/*
 * system debug info
 */
if ($this->countModules('debug')) {
    ?>
<jdoc:include type="modules" name="debug" style="empty" />
<?php } ?>
