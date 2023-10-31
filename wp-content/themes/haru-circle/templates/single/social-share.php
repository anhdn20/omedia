<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$social_sharing    = haru_get_option('social_sharing');
// Set default
if ( empty($social_sharing) ) {
    $social_sharing = '';
}
$sharing_facebook  = isset($social_sharing['facebook']) ? $social_sharing['facebook'] : 1;
$sharing_twitter   = isset($social_sharing['twitter']) ? $social_sharing['twitter'] : 1;
$sharing_google    = isset($social_sharing['google']) ? $social_sharing['google'] : 1;
$sharing_linkedin  = isset($social_sharing['linkedin']) ? $social_sharing['linkedin'] : 1;
$sharing_tumblr    = isset($social_sharing['tumblr']) ? $social_sharing['tumblr'] : 1;
$sharing_pinterest = isset($social_sharing['pinterest']) ? $social_sharing['pinterest'] : 1;

?>
<?php if( $social_sharing != '' ) : ?>
<div class="post-social-share">
    <?php if( ($sharing_facebook == 1) || ($sharing_twitter == 1) || ($sharing_linkedin == 1) || ($sharing_tumblr == 1) || ($sharing_google == 1) || ($sharing_pinterest == 1) ) : ?>
        <div class="social-share-wrapper">
            
            <ul class="social-share">
                <li class="social-label">
                    <?php echo esc_html__( 'Share: ','haru-circle'); ?>
                </li>
                <?php if ( $sharing_facebook == 1 ) : ?>
                    <li>
                        <a onclick="window.open('https://www.facebook.com/sharer.php?u=<?php echo esc_attr( urlencode(get_permalink()) ); ?>', 'sharer', 'toolbar=0,status=0,width=620,height=280');"  href="javascript:;">
                            <i class="fa fa-facebook"></i>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ( $sharing_twitter == 1 ) :  ?>
                    <li>
                        <a onclick="popUp=window.open('http://twitter.com/share?text=<?php echo esc_attr(urlencode(get_the_title())); ?>&amp;url=<?php echo esc_attr(urlencode(get_permalink())); ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;"  href="javascript:;">
                            <i class="fa fa-twitter"></i>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ( $sharing_google == 1 ) :  ?>
                    <li>
                        <a href="javascript:;" onclick="popUp=window.open('https://plus.google.com/share?url=<?php echo esc_attr(urlencode(get_permalink())); ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;">
                            <i class="fa fa-google-plus"></i>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ( $sharing_linkedin == 1 ) : ?>
                    <li>
                        <a onclick="popUp=window.open('http://linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_attr(urlencode(get_permalink())); ?>&amp;title=<?php echo esc_attr(urlencode(get_the_title())); ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" href="javascript:;">
                            <i class="fa fa-linkedin"></i>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ( $sharing_tumblr == 1 ) :  ?>
                    <li>
                        <a onclick="popUp=window.open('http://www.tumblr.com/share/link?url=<?php echo esc_attr(urlencode(get_permalink())); ?>&amp;name=<?php echo esc_attr(urlencode(get_the_title())); ?>&amp;description=<?php echo esc_attr(urlencode(get_the_excerpt())); ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" href="javascript:;">
                            <i class="fa fa-tumblr"></i>
                        </a>
                    </li>

                <?php endif; ?>

                <?php if ( $sharing_pinterest == 1 ) :  ?>
                    <li>
                        <a onclick="popUp=window.open('http://pinterest.com/pin/create/button/?url=<?php echo esc_attr(urlencode(get_permalink())); ?>&amp;description=<?php echo esc_attr(urlencode(get_the_title())); ?>&amp;media=<?php $arrImages = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); echo has_post_thumbnail() ? esc_attr($arrImages[0])  : "" ; ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" href="javascript:;">
                            <i class="fa fa-pinterest"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>