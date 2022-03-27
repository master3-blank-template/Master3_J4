<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   (C) 2011 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;

$jsIcons = Factory::getContainer()
    ->get(Joomla\CMS\Application\SiteApplication::class)
    ->getTemplate(true)
    ->params
    ->get('jsIcons', 'none') != 'none';

// Create shortcut
$urls = json_decode($this->item->urls);

// Create shortcuts to some parameters.
$params = $this->item->params;
if ($urls && (!empty($urls->urla) || !empty($urls->urlb) || !empty($urls->urlc))) {
    ?>
    <div class="uk-flex uk-flex-wrap uk-margin links" data-uk-margin>
        <?php
        $urlarray = array(
            array($urls->urla, $urls->urlatext, $urls->targeta, 'a'),
            array($urls->urlb, $urls->urlbtext, $urls->targetb, 'b'),
            array($urls->urlc, $urls->urlctext, $urls->targetc, 'c')
        );

        $iter = 0;

        foreach ($urlarray as $url) {
            $link   = $url[0];
            $label  = $url[1];
            $target = $url[2];
            $id     = $url[3];

            if (!$link) {
                continue;
            }

            if ($iter) {
                echo '<span>,&nbsp;</span>';
            } else {
                if ($jsIcons) {
                    echo '<span class="uk-flex-inline uk-margin-small-right" data-uk-icon="icon:link" aria-hidden="true"></span>';
                }
            }
            $iter++;

            // If no label is present, take the link
            $label = $label ?: $link;

            // If no target is present, use the default
            $target = $target ?: $params->get('target' . $id);
        ?>
            <span class="link-<?php echo $id; ?>">
                <?php
                // Compute the correct link

                switch ($target) {
                    case 1:
                        // Open in a new window
                        echo '<a href="' . htmlspecialchars($link, ENT_COMPAT, 'UTF-8')
                            . '" target="_blank" rel="nofollow noopener noreferrer">'
                            . htmlspecialchars($label, ENT_COMPAT, 'UTF-8') . '</a>';
                        break;

                    case 2:
                        // Open in a popup window
                        $attribs = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=600';
                        echo "<a href=\"" . htmlspecialchars($link, ENT_COMPAT, 'UTF-8')
                            . "\" onclick=\"window.open(this.href, 'targetWindow', '" . $attribs . "'); return false;\" rel=\"noopener noreferrer\">"
                            . htmlspecialchars($label, ENT_COMPAT, 'UTF-8') . '</a>';
                        break;

                    case 3:
                        // Open in a modal
                        echo '<a  href="#acrticle-link-' . $id . '" data-uk-toggle>' . htmlspecialchars($label, ENT_COMPAT, 'UTF-8') . '</a>';
                        echo '
                        <div id="acrticle-link-' . $id . '" class="uk-modal-container uk-flex-top" data-uk-modal>
                            <div class="uk-modal-dialog uk-margin-auto-vertical">
                                <button class="uk-modal-close-outside" type="button" data-uk-close></button>
                                <div class="uk-position-relative" style="height:80vh">
                                    <iframe src="' . htmlspecialchars($link, ENT_COMPAT, 'UTF-8') . '" width="100%" height="100%"></iframe>
                                </div>
                            </div>
                        </div>';
                        break;

                    default:
                        // Open in parent window
                        echo '<a href="' . htmlspecialchars($link, ENT_COMPAT, 'UTF-8') . '" rel="nofollow">' .
                            htmlspecialchars($label, ENT_COMPAT, 'UTF-8') . ' </a>';
                        break;
                }
                ?>
            </span>
        <?php } ?>
    </div>
<?php } ?>
