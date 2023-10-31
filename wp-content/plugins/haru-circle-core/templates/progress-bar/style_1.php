<?php
/**
 * @package    HaruTheme/Haru Pharmacy
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/
extract( $atts );

$values    = (array)vc_param_group_parse_atts( $values );
// Enqueue assets

?>
<div class="progress-bar-shortcode-wrapper <?php echo $layout_type . ' ' . $el_class; ?>">
    <div class="bar-list">
        <?php foreach( $values as $bar ) : ?>
        <div class="bar-item">
            <div class="bar-label"><?php echo esc_html( $bar['name'] ); ?></div>
            <div class="progress skill-bar ">
                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo esc_html( $bar['value'] ); ?>" aria-valuemin="0" aria-valuemax="100">
                    <span class="skill"><?php echo esc_html( $bar['value'] . $units ); ?></span>
                    <!-- <span class="popOver" data-toggle="tooltip" data-placement="top" title="<?php echo esc_html( $bar['value'] . $units ); ?>"> </span> -->
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>