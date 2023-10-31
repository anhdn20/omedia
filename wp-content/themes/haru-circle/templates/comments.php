<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( post_password_required() ) {
    return;
}
?>
<?php if ( comments_open() || get_comments_number() ) : ?>
    <div id="comments" class="post-comments">
        <?php if ( have_comments() ) : ?>
            <h1 class="comments-title">
                    <?php comments_number(esc_html__('No Comments', 'haru-circle'), esc_html__('One Comment', 'haru-circle'), esc_html__('There are % comments', 'haru-circle')); ?>
            </h1>
            <div class="post-comments-list">
                <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
                    <nav class="comment-navigation clearfix pull-right" role="navigation">
                        <?php $paginate_comments_args = array(
                            'prev_text' => '<i class="fa fa-angle-double-left"></i>',
                            'next_text' => '<i class="fa fa-angle-double-right"></i>'
                        );
                        paginate_comments_links($paginate_comments_args);
                        ?>
                    </nav>
                    <div class="clearfix"></div>
                <?php endif; ?>
                <ol class="comment-list clearfix">
                    <?php wp_list_comments(array(
                        'style'       => 'li',
                        'callback'    => 'haru_render_comments',
                        'avatar_size' => 70,
                        'short_ping'  => true,
                    )); ?>
                </ol>
                <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
                    <nav class="comment-navigation clearfix pull-right comment-navigation-bottom" role="navigation">
                        <?php paginate_comments_links($paginate_comments_args); ?>
                    </nav>
                    <div class="clearfix"></div>
                <?php endif; ?>
            </div>
        <?php endif;?>

        <?php if (comments_open()) : ?>
            <div class="post-comments-form">
                <?php haru_comment_form(); ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>