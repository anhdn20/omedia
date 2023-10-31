<?php
/**
 * @package    HaruTheme/Haru Pharmacy
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

extract( $atts );

$args = array(
    'orderby'        => 'post__in',
    'post__in'       => explode(",", $member_ids),
    'posts_per_page' => $posts_per_page, // -1 is Unlimited member
    'post_type'      => 'haru_teammember',
    'post_status'    => 'publish');

if ( $data_source == '' ) {
    $args = array(
        'posts_per_page' => $posts_per_page, // -1 is Unlimited member
        'orderby'        => $orderby,
        'order'          => $order,
        'post_type'      => 'haru_teammember',
        'post_status'    => 'publish',
        'tax_query'      => array(
            array(
                'taxonomy' => 'team_category',
                'field'    => 'slug',
                'terms'    => explode(',', $category),
            )
        )
    );
}
$teammembers = new WP_Query($args);
// Equeue assets
?>
<?php if ( $teammembers->have_posts() ) : ?>
    <div class="teammember-shortcode-wrapper <?php echo esc_attr( $layout_type . ' ' . $el_class ); ?>">
        <div class="teammember-list">
            <?php while( $teammembers->have_posts() ) : $teammembers->the_post(); ?>
            <div class="team-item">
                <?php if ( !empty(get_post_meta( get_the_ID(), 'haru_teammember_url' )) ) : ?>
                <a href="<?php echo esc_url(get_post_meta( get_the_ID(), 'haru_teammember_url', true ));?>" title="<?php the_title(); ?>">
                <?php endif; ?>
                    <div class="team-content">
                        <div class="team-image">
                            <?php the_post_thumbnail('full')?>
                        </div>
                        <div class="team-meta">
                            <h5 class="team-title"><?php the_title(); ?></h5>
                            <?php if( !empty(haru_get_post_meta( get_the_ID(), 'haru_teammember_position' )) ) : ?>
                            <p class="team-position"><?php echo haru_get_post_meta( get_the_ID(), 'haru_teammember_position', true ); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php if ( !empty(haru_get_post_meta( get_the_ID(), 'haru_teammember_url' )) ) : ?>
                </a>
                <?php endif; ?>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
<?php else : ?>
    <div class="item-not-found"><?php echo esc_html__( 'No item found', 'haru-circle' ) ?></div>
<?php endif; ?>