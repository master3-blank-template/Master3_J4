<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  Content.vote
 *
 * @copyright   (C) 2016 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

/**
 * Layout variables
 * -----------------
 * @var   string   $context  The context of the content being passed to the plugin
 * @var   object   &$row     The article object
 * @var   object   &$params  The article params
 * @var   integer  $page     The 'page' number
 * @var   array    $parts    The context segments
 * @var   string   $path     Path to this file
 */

if ($context === 'com_content.categories') {
    return;
}

$star      = '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="star"><polygon points="10 2 12.63 7.27 18.5 8.12 14.25 12.22 15.25 18 10 15.27 4.75 18 5.75 12.22 1.5 8.12 7.37 7.27" fill="red" stroke="none" stroke-width="0"></polygon></svg>';
$starempty = '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="star"><polygon points="10 2 12.63 7.27 18.5 8.12 14.25 12.22 15.25 18 10 15.27 4.75 18 5.75 12.22 1.5 8.12 7.37 7.27" fill="red" stroke="none" stroke-width="0" style="opacity:.5;"></polygon></svg>';

// Get rating
$rating = (float) $row->rating;
$rcount = (int) $row->rating_count;

// Round to 0.5
$rating = round($rating / 0.5) * 0.5;

// Determine number of stars
$stars = $rating;
$img   = '';

for ($i = 0; $i < floor($stars); $i++) {
    $img .= '<span class="uk-flex-inline vote-star">' . $star . '</span>';
}

for ($i = $stars; $i < 5; $i++) {
    $img .= '<span class="uk-flex-inline vote-star-empty">' . $starempty . '</span>';
}

?>
<div class="uk-flex uk-flex-middle rating" role="img" aria-label="<?php echo Text::sprintf('PLG_VOTE_STAR_RATING', $rating); ?>">
    <?php
    echo $img;
    if ($this->params->get('show_total_votes', 0)) {
        echo '<span class="tm-uk-flex-inline uk-margin-small-left">' . Text::sprintf('PLG_VOTE_TOTAL_VOTES', $rcount) . '</span>';
    }
    ?>
    <?php if ($rcount) { ?>
        <span class="uk-hidden" itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating">
            <?php echo Text::sprintf('PLG_VOTE_USER_RATING', '<span itemprop="ratingValue">' . $rating . '</span>', '<span itemprop="bestRating">5</span>'); ?>
            <meta itemprop="ratingCount" content="<?php echo $rcount; ?>">
            <meta itemprop="worstRating" content="1">
        </span>
    <?php } ?>
</div>
