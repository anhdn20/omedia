<?php 
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

get_header();
?>
<section class="haru-404-page">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="haru-content-404">
                    <div class="page-content">
                        <h2 class="entry-title haru-title-404"><?php echo esc_html__( '404', 'haru-circle' ); ?></h2>
                        <p class="txt2"><?php echo esc_html__( 'Woops, looks like this page doesn\'t exist', 'haru-circle' ); ?></p>
                        <p class="txt3"><?php echo esc_html__( 'You could either go to homepage', 'haru-circle' ); ?></p>
                        <a href="<?php echo esc_url(home_url( '/' )); ?>" title="<?php echo esc_html__( 'Home Page', 'haru-circle' ) ?>">
                            <i class="fa fa-long-arrow-left" aria-hidden="true"></i><?php echo esc_html__( 'Back to home', 'haru-circle' ); ?>
                        </a>
                    </div>
                    <!-- .page-content -->
                </div>
            </div>
            <!-- /.haru-content-area-->
        </div>
        <!-- /.row-->
    </div>
    <!-- /.container-->
</section>
<?php get_footer(); ?>