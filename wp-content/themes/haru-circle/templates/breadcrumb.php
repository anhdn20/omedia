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
<?php if ( !is_front_page() ) : ?>
    <?php haru_get_breadcrumb(); ?>
<?php else : ?>
    <ul class="breadcrumbs">
        <li><a property="v:url" href="<?php echo esc_url( home_url('/') ); ?>" class="home"><?php echo esc_html__( 'Home','haru-circle' );?> </a></li>
        <li><span><?php echo esc_html__( 'Blog', 'haru-circle' ); ?></span></li>
    </ul>
<?php endif; ?>