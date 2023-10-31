<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

//Add class header customize
$header_customize_class = array('header-customize header-customize-right');

//Check option add to header customize
$enable_header_customize = get_post_meta( get_the_ID(), 'haru_' . 'enable_header_customize_right', false ); // true/false
$header_customize = array();
if ( is_array($enable_header_customize) && !empty($enable_header_customize) ) {
    $enable_header_customize = $enable_header_customize[0];
}

if ( $enable_header_customize == '1' ) {
    $page_header_customize = get_post_meta( get_the_ID(), 'haru_' . 'header_customize_right', true );
    if ( isset($page_header_customize['enable']) && !empty($page_header_customize['enable']) ) {
        $header_customize = explode('||', $page_header_customize['enable']);
    }
} else { // use in theme options
    if ( haru_get_option('option-header-customize-right') == '1' ) {
        $enable_header_customize = true;
        $header_customize_right = haru_get_option('header_customize_right');
        if ( isset($header_customize_right) && isset($header_customize_right['enabled']) && is_array($header_customize_right['enabled']) ) {
            foreach ( $header_customize_right['enabled'] as $key => $value ) {
                $header_customize[] = $key;
            }
        }
    } else {
        return;
    }
}

?>
<?php if ( $enable_header_customize == '1' ) : ?>
    <?php if (count($header_customize) > 0) : ?>
    <div class="<?php echo esc_attr( join(' ', $header_customize_class) ); ?>">
        <?php foreach ( $header_customize as $key ) {
            switch ( $key ) {
                case 'search-button':
                    get_template_part('templates/header/header-customize/search-button');
                    break;
                case 'search-box':
                    get_template_part('templates/header/header-customize/search-box');
                    break;
                case 'social-profile':
                    get_template_part('templates/header/header-customize/social-profile', 'right');
                    break;
                case 'custom-text':
                    get_template_part('templates/header/header-customize/custom-text', 'right');
                    break;
                case 'canvas-menu':
                    get_template_part('templates/header/header-customize/canvas-menu');
                    break;
                case 'search-box-film':
                    get_template_part('templates/header/header-customize/search-box-film');
                    break;
                case 'user-account':
                    get_template_part('templates/header/header-customize/user-account');
                    break;
                case 'film-category':
                    get_template_part('templates/header/header-customize/film-category');
                    break;
            }
        } 
        ?>
    </div>
    <?php endif; ?>
<?php endif; ?>