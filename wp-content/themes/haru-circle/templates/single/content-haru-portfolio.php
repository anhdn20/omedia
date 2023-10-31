<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
        $single_style =  get_post_meta(get_the_ID(), 'portfolio_single_style', true);

        if (!isset($single_style) || $single_style == 'none' || $single_style == '') {
            $single_style = haru_get_option('portfolio_single_style');
        }

        get_template_part( 'templates/single/portfolio' , $single_style );
    ?>
</article>