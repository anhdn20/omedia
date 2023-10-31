<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/
?>
<div class="single-post-tags">
    <?php the_tags('<div class="post-meta-tag"><label>'. esc_html__( 'Tags','haru-circle' ) .': </label>', '', '</div>'); ?>
</div>