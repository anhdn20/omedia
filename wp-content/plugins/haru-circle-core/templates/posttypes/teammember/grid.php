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

$link      = vc_build_link( $link );

$args = array(
    'orderby'        => 'post__in',
    'post__in'       => explode(",", $member_ids),
    'posts_per_page' => $posts_per_page, // -1 is Unlimited member
    'post_type'      => 'haru_teammember',
    'post_status'    => 'publish'
);

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
if ( $layout_type == 'grid' ) {
    wp_enqueue_script( 'match-height', get_template_directory_uri() . '/assets/libraries/match-height/jquery.matchHeight.js', false, true );
}
           
?>
<?php if ( $teammembers->have_posts() ) : ?>
    <div class="teammember-shortcode-wrapper <?php echo esc_attr( $layout_type . ' ' . $el_class ); ?>">
        <div class="teammember-list">
            <div class="team-item team-info">
                <div class="info-content">
                    <h3 class="info-title"><?php echo esc_html($title); ?></h3>
                    <p class="info-description"><?php echo wp_kses_post($description); ?></p>
                </div>
            </div>
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
            <?php if ( $viewmore == 'show' ) : ?>
            <div class="team-item viewmore">
                <?php if ( $link['url'] != '' ) : ?>            
                <a href="<?php echo esc_attr( $link['url'] ) ?>" title="<?php echo esc_attr( $link['title'] ); ?>" target="<?php echo ( strlen( $link['target'] ) > 0 ? esc_attr( $link['target'] ) : '_self' ) ?>">
                    <div class="team-viewmore">
                        <div class="viewmore-button">
                            <div class="plus-sign"><i class="ion-ios-add"></i></div>
                            <p><?php echo esc_html__( 'View More', 'haru-circle' ); ?></p>
                        </div>
                    </div>
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
<?php else : ?>
    <div class="item-not-found"><?php echo esc_html__( 'No item found', 'haru-circle' ) ?></div>
<?php endif; ?>