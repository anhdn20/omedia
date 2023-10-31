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
<?php if ( is_sticky() ) : ?>
<div class="post-meta-sticky"><i class="fa fa-sticky-note"></i><?php echo esc_html( 'Sticky', 'haru-circle' ); ?></div>
<?php endif; ?>
<div class="post-meta-author"><i class="ion-ios-person"></i>
    <?php printf('<a href="%1$s">%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() )); ?>
</div>
<div class="post-meta-date"><i class="ion-ios-calendar"></i><?php echo date_i18n( 'd M, Y', strtotime(get_the_date('Y-m-d')) ); ?></div>
<div class="post-meta-comment">
    <i class="ion-ios-chatbubbles"></i>
    <?php printf('<a href="%1$s">%2$s</a>', esc_url( get_comments_link() ), esc_html( get_comments_number() )); ?>
</div>