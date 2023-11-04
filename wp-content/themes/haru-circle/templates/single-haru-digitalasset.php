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
<?php
/**
 * @hooked - haru_page_heading - 5
 **/
do_action('haru_before_page');
?>
<div class="haru-single-digitalasset">
    <div class="full-width clearfix">
        <div class="row clearfix">
            <!-- Single content -->
            <div class="single-content col-sm-12 col-xs-12">
                <div class="single-wrapper">
                    <?php
                    if( have_posts() ):
                        // Start the Loop.
                        while( have_posts() ) : the_post();
                            /*
                             * Include the post format-specific template for the content. If you want to
                             * use this in a child theme, then include a file called called content-___.php
                             * (where ___ is the post format) and that will be used instead.
                             */
                            get_template_part( 'templates/single/content' , 'haru-digitalasset' );
                        endwhile;
                    else:
                        // If no content, include the "No posts found" template.
                        get_template_part( 'templates/archive/content-none');
                    endif;
                    ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>