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
    <div class="post-wrapper">
        <?php 
            // Docs: https://metabox.io/docs/get-meta-value/
            $film_short_description = get_post_meta( get_the_ID(), 'haru_film' . '_short_description', true );
            $film_director_id       = get_post_meta( get_the_ID(), 'haru_film' . '_director', true );
            $film_director          = get_post( $film_director_id );
            $film_director_link     = get_post_permalink( $film_director_id );

            $film_actor_ids         = get_post_meta( get_the_ID(), 'haru_film' . '_actor', false );

            $film_type              = get_post_meta( get_the_ID(), 'haru_film' . '_type', true );
            $film_episode_number    = get_post_meta( get_the_ID(), 'haru_film' . '_episode_number', true );
            $film_duration          = get_post_meta( get_the_ID(), 'haru_film' . '_duration', true );

            // Trailer
            $film_trailer_id        = get_post_meta( get_the_ID(), 'haru_film' . '_trailer', true );

            // Videos
            $film_videos        = get_post_meta( get_the_ID(), 'haru_film' . '_videos', true ); // true/false

            $film_label = get_post_meta( get_the_ID(), 'haru_film_label', true );
            $film_rating = get_post_meta( get_the_ID(), 'haru_film_rating', true );

        ?>
        <div class="single-film-top">
            <div class="row">
                <div class="col-md-4 col-xs-12 film-thumbnail-wrap">
                    <div class="film-thumbnail">
                        <?php the_post_thumbnail(); ?>
                    </div>
                </div>
                <div class="col-md-8 col-xs-12 film-information-wrap">
                    <div class="film-information">
                        <h1 class="film-title"><?php the_title(); ?></h1>
                        <div class="film-rating">
                            <span class="point"><i class="ion-ios-star"></i><?php echo esc_html( $film_rating ); ?></span>
                            <span class="total"><?php echo esc_html__( '/10', 'haru-circle' ); ?></span>
                            <span class="film-views"><i class="ion-ios-eye"></i><?php echo haru_count_post_views( get_the_ID() ); ?></span>
                            <?php if ( comments_open() ) : ?>
                                <span class="meta-comment">
                                    <i class="ion-ios-chatbubbles"></i>
                                    <?php 
                                        $num_comments = get_comments_number();
                                        if ( $num_comments == 0 ) {
                                            $comments = esc_html__( 'No Comments', 'haru-circle' );
                                        } elseif ( $num_comments > 1 ) {
                                            $comments = $num_comments . esc_html__( ' Comments', 'haru-circle' );
                                        } else {
                                            $comments = esc_html__( '1 Comment', 'haru-circle' );
                                        }
                                        printf('<a href="%1$s">%2$s</a>', esc_url( get_comments_link() ), $comments ); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="film-meta">
                            <ul>
                                <?php if ( isset($film_actor_ids) && !empty($film_actor_ids) ) : ?>
                                <li>
                                    <span class="meta-label"><?php echo esc_html__( 'Actor', 'haru-circle' ); ?></span>
                                    <div class="meta-value">
                                    <?php 
                                        $last_key = array_search( end($film_actor_ids), $film_actor_ids );
                                        foreach( $film_actor_ids as $key => $film_actor_id) : // Can change to false get_post_meta for shorter code
                                        $film_actor      = get_post( $film_actor_id );
                                        $film_actor_link = get_post_permalink( $film_actor_id );
                                    ?>
                                        <?php if ( $key != $last_key ) : ?>
                                        <a href="<?php echo esc_url($film_actor_link); ?>"><?php echo esc_html( $film_actor->post_title ); ?></a>,
                                        <?php else : ?>
                                        <a href="<?php echo esc_url($film_actor_link); ?>"><?php echo esc_html( $film_actor->post_title ); ?></a>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <?php if ( isset($film_director) && !empty($film_director) ) : ?>
                                <li>
                                    <span class="meta-label"><?php echo esc_html__( 'Director', 'haru-circle' ); ?></span>
                                    <div class="meta-value">
                                        <a href="<?php echo esc_url($film_director_link); ?>"><?php echo esc_html( $film_director->post_title ); ?></a>
                                    </div>
                                </li>
                                <?php endif; ?>
                                <li>
                                    <span class="meta-label"><?php echo esc_html__( 'Genre', 'haru-circle' ); ?></span>
                                    <div class="meta-value"><?php echo get_the_term_list( get_the_ID(), 'film_category', '', ', ' ); ?></div>
                                </li>
                                <li>
                                    <span class="meta-label"><?php echo esc_html__( 'Duration', 'haru-circle' ); ?></span>
                                    <div class="meta-value"><?php echo esc_html( $film_duration ); ?><span><?php echo esc_html__( ' minutes', 'haru-circle' ); ?></span></div>
                                </li>
                                <li>
                                    <span class="meta-label"><?php echo esc_html__( 'Release', 'haru-circle' ); ?></span>
                                    <div class="meta-value"><?php echo get_the_term_list( get_the_ID(), 'film_year', '', ', ' ); ?></span></div>
                                </li>
                                <li>
                                    <span class="meta-label"><?php echo esc_html__( 'Country', 'haru-circle' ); ?></span>
                                    <div class="meta-value"><?php echo get_the_term_list( get_the_ID(), 'film_country', '', ', ' ); ?></span></div>
                                </li>
                                <li>
                                    <span class="meta-label"><?php echo esc_html__( 'Type', 'haru-circle' ); ?></span>
                                    <div class="meta-value">
                                        <?php 
                                            if ( $film_type == 'short' ) {
                                                echo esc_html__( 'Short', 'haru-circle' );
                                            } else {
                                                echo esc_html__( 'Series', 'haru-circle' );
                                            }
                                        ?> 
                                    </div>
                                </li>
                                <li>
                                    <span class="meta-label"><?php echo esc_html__( 'Tags', 'haru-circle' ); ?></span>
                                    <div class="meta-value"><?php echo get_the_term_list( get_the_ID(), 'film_tag', '', ', ' ); ?></div>
                                </li>
                            </ul>
                            <div class="film-view-links">
                                <?php
                                    $player_type = haru_get_option('player_type');
                                    $player_js = haru_get_option('player_js');
                                    if ( $player_type == 'player_popup' ) :
                                ?>
                                <a href="javascript:;" class="view-film-button" data-id="<?php echo esc_attr($post->ID); ?>" data-player="<?php echo esc_attr( $player_js ); ?>" data-server=""><i class="ion-ios-play"></i><?php echo esc_html__( 'Watch Now', 'haru-circle' ); ?></a>
                                <?php else : ?>
                                    <a href="javascript:;" class="film-player-direct" data-id="<?php echo esc_attr($post->ID); ?>" data-player="<?php echo esc_attr( $player_js ); ?>" data-server=""><i class="ion-ios-play"></i><?php echo esc_html__( 'Watch Now', 'haru-circle' ); ?></a>
                                <?php endif; ?>
                                <!-- Trailer popup -->
                                <a href="javascript:;" class="view-trailer-button" data-id="<?php echo esc_attr( $film_trailer_id ); ?>"><i class="ion-md-camera"></i><?php echo esc_html__( 'View Trailer', 'haru-circle' ); ?></a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Film Player -->
        <?php if ( $player_type != 'player_popup' ) : ?>
        <div class="player-direct">
            <?php get_template_part('templates/single/film-player-direct'); ?>
        </div>
        <?php endif; ?>

        <div class="single-film-overview">
            <h3 class="overview-title"><?php echo esc_html__( 'Overview', 'haru-circle' ); ?></h3>
            <p class="single-film-content">
                <?php the_content(); ?>
            </p>
        </div>

        <?php if ( isset($film_actor_ids) && !empty($film_actor_ids) ) : ?>
        <div class="single-film-actor">
            <h3 class="actor-title"><?php echo esc_html__( 'Cast & Crew', 'haru-circle' ); ?></h3>
            <div class="haru-carousel actor-list owl-carousel owl-theme"
                data-items="4"
                data-margin="30"
                data-autoplay="false"
                data-slide-duration="5000"
            >
                <?php foreach( $film_actor_ids as $film_actor_id) : // Can change to false get_post_meta for shorter code
                    $film_actor      = get_post( $film_actor_id );
                    $film_actor_link = get_post_permalink( $film_actor_id );
                ?>
                <div class="film-actor">
                    <div class="film-image">
                        <?php echo get_the_post_thumbnail( $film_actor_id ); ?>
                    </div>
                    <div class="film-meta">
                        <h5 class="film-title"><a href="<?php echo esc_url( $film_actor_link ); ?>" target="_self"><?php echo esc_html( $film_actor->post_title ); ?></a></h5>
                        <div class="film-category">
                            <?php echo get_the_term_list( $film_actor_id, 'actor_category', '', ', ' ); ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</article>