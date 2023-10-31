<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/
extract( $atts );

$timelines_arr    = (array)vc_param_group_parse_atts( $timeline );
// Enqueue assets
if ( ( $layout_type == 'carousel' ) ) {
    wp_enqueue_style( 'slick', get_template_directory_uri() . '/assets/libraries/slick/slick.css', array() );
   	wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/libraries/slick/slick.min.js', array( 'jquery' ), '', true );
}
?>
<div class="timeline-shortcode-wrap <?php echo esc_attr( $layout_type . ' ' . $el_class ); ?>">
    <div class="timeline-shortcode-content">
    	<div id="timeline-thumb" class="timeline-slider-nav" 
			data-slick='{"slidesToShow" : 3, "slidesToScroll" : 1, "arrows" : false, "infinite" : false, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "asNavFor" : ".timeline-slider-for", "responsive" : [{"breakpoint": 767,"settings":{"slidesToShow": 1}}] }'>
            <?php foreach( $timelines_arr as $key => $timeline ) : 
            ?>
                <div class="thumb-time">
                	<span class="time-dot"></span>
                </div>
            <?php endforeach; ?>
        </div>
        <div id="timeline-content" class="timeline-slider-for" 
    		data-slick='{"slidesToShow" : 3, "slidesToScroll": 1, "infinite" : false, "asNavFor" : ".timeline-slider-nav", "responsive" : [{"breakpoint": 767,"settings":{"slidesToShow": 1}}] }'>
            <?php
                foreach( $timelines_arr as $key => $timeline ) : 
                    $link = '';
                    if ( isset($timeline['link']) ) {
                        $link = vc_build_link( $timeline['link'] );
                    }
            ?>
                <div class="timeline-item">
                	<h5><?php echo esc_html( $timeline['time'] ); ?></h5>
                	<h6 class="timeline-title">
                    	<?php if ( $link != '' ) : ?>
                        <a href="<?php echo esc_url( $link['url'] ); ?>" target="<?php echo esc_attr( ($link['target'] != '') ? $link['target'] : '_self' ); ?>">
                        <?php endif; ?>
                        <?php echo esc_html( $timeline['title'] );  ?>
                        <?php if ( $link != '' ) : ?>
                        </a>
                        <?php endif; ?>
                    </h6>
                    <p class="description"><?php echo esc_html( $timeline['description'] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>