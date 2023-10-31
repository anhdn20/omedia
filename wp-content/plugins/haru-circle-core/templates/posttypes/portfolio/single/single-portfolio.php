<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

get_header();

if ( have_posts() ) {
    // Start the Loop.
    while ( have_posts() ) : the_post();
        $detail_style =  get_post_meta(get_the_ID(), 'portfolio_detail_style', true);

        if (!isset($detail_style) || $detail_style == 'none' || $detail_style == '') {
            // $detail_style = haru_get_option('portfolio-single-style');
            $detail_style = 'detail-01';
        }

        // include_once(plugin_dir_path( __FILE__ ).'/'.$detail_style.'.php');
        haru_get_template('posttypes/portfolio/single/' . $detail_style . '.php', '', '', '' );
    endwhile;


    }
?>

<?php

// if( (NULL !== haru_get_option('show_portfolio_related')) && haru_get_option('show_portfolio_related') == '1' )
//     include_once(plugin_dir_path( __FILE__ ).'/related.php');

?>

<!-- <script type="text/javascript">
    (function($) {
        "use strict";
        $(document).ready(function(){

            $('a','.portfolio-full .share').each(function(){
                $(this).click(function(){
                    var href = $(this).attr('data-href');
                    var leftPosition, topPosition;
                    var width = 400;
                    var height = 300;
                    var leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
                    var topPosition = (window.screen.height / 2) - ((height / 2) + 50);
                    //Open the window.
                    window.open(href, "", "width=300, height=200,left=" + leftPosition + ",top=" + topPosition);
                })
            })

            $("a[rel^='prettyPhoto']").prettyPhoto({
                theme: 'light_rounded',
                slideshow: 5000,
                deeplinking: false,
                social_tools: false
            });
        })
    })(jQuery);
</script> -->

<?php get_footer(); ?>