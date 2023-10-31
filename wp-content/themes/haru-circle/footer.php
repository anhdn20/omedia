<?php
/**
 * The template for displaying the footer
 *
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
 */
?>
            <?php 
                /*
                * @hooked - haru main content end
                */
                do_action( 'haru_main_content_end' );
            ?>
            </div>
            <!-- Close HARU Content Main -->

            <?php 
                // Process class for footer
                if ( post_type_exists('haru_footer') && (get_posts( 'post_type=haru_footer' )) ) : // Use this only when have footer post type
                    $footer_id = get_post_meta( get_the_ID(), 'haru_'.'footer', true );
                    if ( $footer_id == '' ) {
                        $footer_id = haru_get_option('footer');
                    }
                    $content_post = get_post($footer_id);
            ?>
            <footer id="haru-footer-main" class="<?php echo esc_attr( $content_post->post_name ); ?>">
                <?php
                    /*
                    * @hooked - haru_footer_block - 5
                    */
                    do_action( 'haru_footer_main' );
                ?>
            </footer>
            <?php 
                else : // Use this for theme unit test
            ?>
            <footer>
                <div class="container original-footer">
                    <?php echo '&copy; ' . date('Y') . ' ' . esc_html( get_bloginfo() ); ?>
                </div>
            </footer>
            <?php 
                endif;
            ?>
        </div>
        <!-- Close haru main -->
        <?php
            /*
            * @hooked - haru_back_to_top - 5
            * @hooked - haru_ajax_loading - 10
            */
            do_action( 'haru_after_page_main' );

        ?>
    <?php wp_footer(); ?>
    </body>
</html>