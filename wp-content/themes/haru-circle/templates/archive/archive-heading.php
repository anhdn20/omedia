<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$show_archive_title = haru_get_option('show_archive_title');
// Custom post type archive heading
if ( is_post_type_archive('haru_actor') || is_tax('actor_category') ) {
    $show_archive_title = haru_get_option('show_archive_actor_title');
}
if ( is_post_type_archive('haru_director') || is_tax('director_category') ) {
    $show_archive_title = haru_get_option('show_archive_director_title');
}
if ( is_post_type_archive('haru_video') || is_tax('video_category') ) {
    $show_archive_title = haru_get_option('show_archive_video_title');
}
if ( is_post_type_archive('haru_digitalasset') || is_tax('digitalasset_category') ) {
    $show_archive_title = haru_get_option('show_archive_digitalasset_title');
}
if ( is_post_type_archive('haru_film') || is_tax('film_category') ) {
    $show_archive_title = haru_get_option('show_archive_film_title');
}
// Set default
if ( empty($show_archive_title) && $show_archive_title === false ) {
    $show_archive_title = 1;
}

$on_front           = get_option('show_on_front'); // core in redux
$page_title         = '';
$page_sub_title     = strip_tags(term_description());

if (!have_posts()) {
    $page_title = esc_html__( 'Nothing Found', 'haru-circle' );
} elseif (is_home()) {
    if (($on_front == 'page' && get_queried_object_id() == get_post(get_option('page_for_posts'))->ID) || ($on_front == 'posts')) {
        $page_title = esc_html__( 'Blog', 'haru-circle' );
    } else {
        $page_title = '';
    }
} elseif (is_category()) {
    $page_title = single_cat_title('', false);
} elseif (is_tag()) {
    $page_title = single_tag_title(esc_html__( 'Tags: ', 'haru-circle' ), false);
} elseif (is_author()) {
    $page_title = sprintf(esc_html__( 'Author: %s', 'haru-circle' ), get_the_author());
} elseif (is_day()) {
    $page_title = sprintf(esc_html__( 'Daily Archives: %s', 'haru-circle' ), get_the_date());
} elseif (is_month()) {
    $page_title = sprintf(esc_html__( 'Monthly Archives: %s', 'haru-circle' ), get_the_date(_x('F Y', 'monthly archives date format', 'haru-circle')));
} elseif (is_year()) {
    $page_title = sprintf(esc_html__( 'Yearly Archives: %s', 'haru-circle' ), get_the_date(_x('Y', 'yearly archives date format', 'haru-circle')));
} elseif (is_search()) {
    $page_title = sprintf(esc_html__( 'Search Results for: %s', 'haru-circle' ), get_search_query());
} elseif (is_tax('post_format', 'post-format-aside')) {
    $page_title = esc_html__( 'Asides', 'haru-circle' );
} elseif (is_tax('post_format', 'post-format-gallery')) {
    $page_title = esc_html__( 'Galleries', 'haru-circle' );
} elseif (is_tax('post_format', 'post-format-image')) {
    $page_title = esc_html__( 'Images', 'haru-circle' );
} elseif (is_tax('post_format', 'post-format-video')) {
    $page_title = esc_html__( 'Videos', 'haru-circle' );
} elseif (is_tax('post_format', 'post-format-quote')) {
    $page_title = esc_html__( 'Quotes', 'haru-circle' );
} elseif (is_tax('post_format', 'post-format-link')) {
    $page_title = esc_html__( 'Links', 'haru-circle' );
} elseif (is_tax('post_format', 'post-format-status')) {
    $page_title = esc_html__( 'Statuses', 'haru-circle' );
} elseif (is_tax('post_format', 'post-format-audio')) {
    $page_title = esc_html__( 'Audios', 'haru-circle' );
} elseif (is_tax('post_format', 'post-format-chat')) {
    $page_title = esc_html__( 'Chats', 'haru-circle' );
// Custom Post type
} elseif (is_post_type_archive('haru_video')) {
    $page_title = esc_html__( 'Videos', 'haru-circle' );
} elseif (is_post_type_archive('haru_digitalasset')) {
    $page_title = esc_html__( 'Digital Assets', 'haru-circle' );
} elseif (is_post_type_archive('haru_actor')) {
    $page_title = esc_html__( 'Actors', 'haru-circle' );
} elseif (is_post_type_archive('haru_director')) {
    $page_title = esc_html__( 'Directors', 'haru-circle' );
} elseif (is_post_type_archive('haru_film')) {
    $page_title = esc_html__( 'Films', 'haru-circle' );
// Custom Post type taxonomy
} elseif (is_tax('video_category')) {
    $page_title = esc_html__( 'Videos', 'haru-circle' );
} elseif (is_tax('digitalasset_category')) {
    $page_title = esc_html__( 'Digital Assets', 'haru-circle' );
} elseif (is_tax('actor_category')) {
    $page_title = esc_html__( 'Actors', 'haru-circle' );
} elseif (is_tax('director_category')) {
    $page_title = esc_html__( 'Directors', 'haru-circle' );
} elseif (is_tax('film_category')) {
    $page_title = esc_html__( 'Films', 'haru-circle' );
} else {
    $page_title = esc_html__( 'Archives', 'haru-circle' );
}

// Process archive title layout
$section_page_title_class = array('haru-page-title-section');
$archive_title_layout     = haru_get_option('archive_title_layout');
// Custom post type archive heading
if ( is_post_type_archive('haru_actor') || is_tax('actor_category') ) {
    $archive_title_layout     = haru_get_option('archive_actor_title_layout');
}
if ( is_post_type_archive('haru_director') || is_tax('director_category') ) {
    $archive_title_layout     = haru_get_option('archive_director_title_layout');
}
if ( is_post_type_archive('haru_video') || is_tax('video_category') ) {
    $archive_title_layout     = haru_get_option('archive_video_title_layout');
}
if ( is_post_type_archive('haru_digitalasset') || is_tax('digitalasset_category') ) {
    $archive_title_layout     = haru_get_option('archive_digitalasset_title_layout');
}
if ( is_post_type_archive('haru_film') || is_tax('film_category') ) {
    $archive_title_layout     = haru_get_option('archive_film_title_layout');
}

if ( in_array($archive_title_layout, array('container')) ) {
    $section_page_title_class[] = $archive_title_layout;
}

// Process archive title background image
$page_title_bg_image = '';
$cat                 = get_queried_object();
if ($cat && property_exists( $cat, 'term_id' )) {
    $page_title_bg_image = get_tax_meta($cat, 'haru_'.'page_title_background'); // Category page title
}

if( !$page_title_bg_image || ($page_title_bg_image === '') ) {
    $page_title_bg_image = haru_get_option('archive_title_bg_image');
}
// Custom post type title_bg_image
if ( is_post_type_archive('haru_actor') || is_tax('actor_category') ) {
    $page_title_bg_image     = haru_get_option('archive_actor_title_bg_image');
}
if ( is_post_type_archive('haru_director') || is_tax('director_category') ) {
    $page_title_bg_image     = haru_get_option('archive_director_title_bg_image');
}
if ( is_post_type_archive('haru_video') || is_tax('video_category') ) {
    $page_title_bg_image     = haru_get_option('archive_video_title_bg_image');
}
if ( is_post_type_archive('haru_digitalasset') || is_tax('digitalasset_category') ) {
    $page_title_bg_image     = haru_get_option('archive_digitalasset_title_bg_image');
}
if ( is_post_type_archive('haru_film') || is_tax('film_category') ) {
    $page_title_bg_image     = haru_get_option('archive_film_title_bg_image');
}


if (isset($page_title_bg_image) && isset($page_title_bg_image['url'])) {
    $page_title_bg_image_url = $page_title_bg_image['url'];
} else {
    $page_title_bg_image_url = '';
}
// Set default
if ( empty($page_title_bg_image_url) ) {
    $page_title_bg_image_url = get_template_directory_uri() . '/framework/admin-assets/images/theme-options/bg-page-title.jpg';
}

// Process style archive_title_bg_image and archive_title_parallax
$page_title_wrap_class   = array();
$page_title_wrap_class[] = 'haru-page-title-wrapper';

$custom_styles = array();

if ($page_title_bg_image_url != '') {
    $page_title_wrap_class[] = 'page-title-wrap-bg';
    $custom_styles[]         = 'background-image: url(' . $page_title_bg_image_url . ');';
}

$custom_style = '';
if ($custom_styles) {
    $custom_style = 'style="'. join(';', $custom_styles).'"';
}

$page_title_parallax = haru_get_option('archive_title_parallax');
// Custom post type archive_actor_title_parallax
if ( is_post_type_archive('haru_actor') || is_tax('actor_category') ) {
    $page_title_parallax     = haru_get_option('archive_actor_title_parallax');
}
if ( is_post_type_archive('haru_director') || is_tax('director_category') ) {
    $page_title_parallax     = haru_get_option('archive_director_title_parallax');
}
if ( is_post_type_archive('haru_video') || is_tax('video_category') ) {
    $page_title_parallax     = haru_get_option('archive_video_title_parallax');
}
if ( is_post_type_archive('haru_digitalasset') || is_tax('digitalasset_category') ) {
    $page_title_parallax     = haru_get_option('archive_digitalasset_title_parallax');
}
if ( is_post_type_archive('haru_film') || is_tax('film_category') ) {
    $page_title_parallax     = haru_get_option('archive_film_title_parallax');
}

if ( !empty($page_title_bg_image_url) && ($page_title_parallax == '1') ) {
    $custom_style            .= ' data-stellar-background-ratio="0.5"';
    $page_title_wrap_class[] = 'page-title-parallax';
}

// Process breadcrumbs_in_archive_title
$breadcrumbs_in_archive_title = isset($_GET['breadcrumbs']) ? $_GET['breadcrumbs'] : '';
if (!in_array($breadcrumbs_in_archive_title, array('1','0'))) {
    $breadcrumbs_in_archive_title = haru_get_option('breadcrumbs_in_archive_title');
}
// Custom post type title_bg_image
if ( is_post_type_archive('haru_actor') || is_tax('actor_category') ) {
    $breadcrumbs_in_archive_title     = haru_get_option('breadcrumbs_in_archive_actor_title');
}
if ( is_post_type_archive('haru_director') || is_tax('director_category') ) {
    $breadcrumbs_in_archive_title     = haru_get_option('breadcrumbs_in_archive_director_title');
}
if ( is_post_type_archive('haru_video') || is_tax('video_category') ) {
    $breadcrumbs_in_archive_title     = haru_get_option('breadcrumbs_in_archive_video_title');
}
if ( is_post_type_archive('haru_digitalasset') || is_tax('digitalasset_category') ) {
    $breadcrumbs_in_archive_title     = haru_get_option('breadcrumbs_in_archive_digitalasset_title');
}
if ( is_post_type_archive('haru_film') || is_tax('film_category') ) {
    $breadcrumbs_in_archive_title     = haru_get_option('breadcrumbs_in_archive_film_title');
}

// Set default
if (empty($breadcrumbs_in_archive_title)) {
    $breadcrumbs_in_archive_title = 0;
}
// Add class for style when not use breadcrumbs
if ( $breadcrumbs_in_archive_title != 1 ) {
    $page_title_wrap_class[] = 'no-breadcrumbs';
}
?>

<?php if( ($show_archive_title == 1) || ($breadcrumbs_in_archive_title == 1) ): ?>
    <div class="<?php echo esc_attr( join(' ', $section_page_title_class) ); ?>" <?php echo wp_kses_post($custom_style); ?>>
        <?php if($show_archive_title == 1): ?>
            <section class="<?php echo esc_attr( join(' ',$page_title_wrap_class) ); ?>" >
                <div class="container">
                    <div class="page-title-inner">
                        <div class="block-center-inner">
                            <h2><?php echo esc_html($page_title); ?></h2>
                            <?php if ($page_sub_title != '') : ?>
                                <span class="page-sub-title"><?php echo esc_html($page_sub_title); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        <?php if( $breadcrumbs_in_archive_title == 1 ): ?>
            <div class="haru-breadcrumb-wrapper">
                <div class="container">
                    <?php get_template_part( 'templates/breadcrumb' ); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>