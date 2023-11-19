<?php 
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

// Load the HARU theme framework, all functions for theme will in includes folder in framework folder
require get_template_directory()  . '/framework/haru-framework.php';

// Remove plugin flag from redux. Get rid of redirect
add_action( 'redux/construct', 'haru_remove_as_plugin_flag' );

function haru_remove_as_plugin_flag() {
    ReduxFramework::$_as_plugin = false;
}


// Disable revslider notice.
if ( function_exists( 'rev_slider_shortcode' ) ) {
    add_action( 'admin_init', 'haru_disable_revslider_notice' );
}

function haru_disable_revslider_notice() {
    update_option( 'revslider-valid-notice', 'false' );
}

add_action('wp_footer', 'digital_css',1);
function digital_css(){
    ?>
    <style>
        :root{
            --fifth-text-color: #aaa;
            --secondary-text-color: #8c8c8c;
        }
        .digitalasset-shortcode-wrapper.grid .digitalasset-content .digitalasset-filter.align_left, .digitalasset-shortcode-wrapper.masonry .digitalasset-content .digitalasset-filter.align_left, .digitalasset-shortcode-wrapper.grid_special .digitalasset-content .digitalasset-filter.align_left, .digitalasset-shortcode-ajax.grid .digitalasset-content .digitalasset-filter.align_left, .digitalasset-shortcode-ajax.masonry .digitalasset-content .digitalasset-filter.align_left, .digitalasset-shortcode-ajax.grid_special .digitalasset-content .digitalasset-filter.align_left{
            text-align: left;
        }
        .digitalasset-shortcode-wrapper.grid .digitalasset-content .digitalasset-filter, .digitalasset-shortcode-ajax.grid .digitalasset-content .digitalasset-filter, .digitalasset-shortcode-wrapper.masonry .digitalasset-content .digitalasset-filter, .digitalasset-shortcode-ajax.masonry .digitalasset-content .digitalasset-filter, .digitalasset-shortcode-wrapper.grid_special .digitalasset-content .digitalasset-filter, .digitalasset-shortcode-ajax.grid_special .digitalasset-content .digitalasset-filter{
            list-style: none;
            list-style-type: none;
            padding: 0;
        }
        .digitalasset-shortcode-wrapper.grid .digitalasset-content .digitalasset-filter.style_1 li, .digitalasset-shortcode-ajax.grid .digitalasset-content .digitalasset-filter.style_1 li, .digitalasset-shortcode-wrapper.masonry .digitalasset-content .digitalasset-filter.style_1 li, .digitalasset-shortcode-ajax.masonry .digitalasset-content .digitalasset-filter.style_1 li, .digitalasset-shortcode-wrapper.grid_special .digitalasset-content .digitalasset-filter.style_1 li, .digitalasset-shortcode-ajax.grid_special .digitalasset-content .digitalasset-filter.style_1 li{
            display: inline-block;
            padding: 0 5px;
            margin-bottom: 10px;
        }
        .digitalasset-shortcode-wrapper.grid .digitalasset-content .digitalasset-filter.style_1 li a:hover, .digitalasset-shortcode-wrapper.grid .digitalasset-content .digitalasset-filter.style_1 li a.selected, .digitalasset-shortcode-wrapper.masonry .digitalasset-content .digitalasset-filter.style_1 li a:hover, .digitalasset-shortcode-wrapper.masonry .digitalasset-content .digitalasset-filter.style_1 li a.selected, .digitalasset-shortcode-wrapper.grid_special .digitalasset-content .digitalasset-filter.style_1 li a:hover, .digitalasset-shortcode-wrapper.grid_special .digitalasset-content .digitalasset-filter.style_1 li a.selected, .digitalasset-shortcode-ajax.grid .digitalasset-content .digitalasset-filter.style_1 li a:hover, .digitalasset-shortcode-ajax.grid .digitalasset-content .digitalasset-filter.style_1 li a.selected, .digitalasset-shortcode-ajax.masonry .digitalasset-content .digitalasset-filter.style_1 li a:hover, .digitalasset-shortcode-ajax.masonry .digitalasset-content .digitalasset-filter.style_1 li a.selected, .digitalasset-shortcode-ajax.grid_special .digitalasset-content .digitalasset-filter.style_1 li a:hover, .digitalasset-shortcode-ajax.grid_special .digitalasset-content .digitalasset-filter.style_1 li a.selected{
            background-color: #fd6500;
            border-color: #fd6500;
            color: #fff;
            -webkit-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
        }
        .digitalasset-shortcode-wrapper.grid .digitalasset-content .digitalasset-filter.style_1 li a, .digitalasset-shortcode-wrapper.masonry .digitalasset-content .digitalasset-filter.style_1 li a, .digitalasset-shortcode-wrapper.grid_special .digitalasset-content .digitalasset-filter.style_1 li a, .digitalasset-shortcode-ajax.grid .digitalasset-content .digitalasset-filter.style_1 li a, .digitalasset-shortcode-ajax.masonry .digitalasset-content .digitalasset-filter.style_1 li a, .digitalasset-shortcode-ajax.grid_special .digitalasset-content .digitalasset-filter.style_1 li a{
            border: 2px solid #e0e0e0;
            display: inline-block;
            font-size: 13px;
            padding: 6px 25px;
            text-transform: uppercase;
            -webkit-border-radius: 20px;
            -moz-border-radius: 20px;
            border-radius: 20px;
            -webkit-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
        }

        .digitalasset-list.columns-2{
            display: flex;
            justify-content: space-between;
            gap: 35px;
            flex-wrap: wrap;
        }
        .digitalasset-list.columns-2 > .digitalasset-item{
            width: calc(50% - 17.5px);
            border-radius: 15px;
            /* border: 1px solid #ccc; */
            overflow: hidden;
        }

        .digitalasset-list.columns-3{
            display: flex;
            justify-content: flex-start;
            gap: 56px;
            flex-wrap: wrap;
        }
        .digitalasset-list.columns-3 > .digitalasset-item{
            width: calc(33.333% - 40px);
            border-radius: 15px;
            /* border: 1px solid #ccc; */
            overflow: hidden;
        }
        
        .digitalasset-list.columns-4{
            display: flex;
            justify-content: flex-start;
            gap: 50px;
            flex-wrap: wrap;
        }
        .digitalasset-list.columns-4 > .digitalasset-item{
            width: calc(25% - 40px);
            border-radius: 15px;
            /* border: 1px solid #ccc; */
            overflow: hidden;
        }
        
        .digitalasset-list.columns-5{
            display: flex;
            justify-content: space-between;
            gap: 25px;
            flex-wrap: wrap;
        }
        .digitalasset-list.columns-5 > .digitalasset-item{
            width: calc(25% - 80px);
            border-radius: 15px;
            /* border: 1px solid #ccc; */
            overflow: hidden;
        }
        .haru-archive-blog.digitalasset{
            padding-top: 40px;
        }

        #digital-filter-form{
            display: flex;
            margin-bottom: 20px;
            justify-content: flex-end;
            row-gap: 20px;
			column-gap: 20px;
        }

        #digital-filter-form select{
            padding: 15px 60px 15px 15px;
            background-color: #1e1e23;
            border: 0;
            border-radius: 15px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }
        #digital-filter-form select span{
            position: absolute;
            right: 10px; 
            top: 50%; 
            transform: translateY(-50%); 
            width: 20px; 
            height: 20px; 
        }

        .dgtass-name {
            display: grid;
            grid-row-gap: 0.3rem;
            width: 78%;
        }
        .dgtass-info{
            display: grid;
/*             grid-row-gap: 0.5rem; */
            text-align: right;
        }
        .dgtass-title{
            margin-top: 0px;
            margin-bottom: 0px;
            font-size: 1.3rem;
            font-weight: 500;
            color: var(--fifth-text-color);
        }

        .dgtass-meta{
            padding: 15px 20px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            background-color: #1e1e23;
        }

        .dgtass-name .dgtass-title{
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding-right: 0.5rem;
        }
        .dgtass-name .dgtass-title a,
        .dgtass-price{
            color: var(--fifth-text-color);
            font-size: 1.1em;
        }
        .dgtass-category {
            overflow: hidden;
            text-overflow: ellipsis;
            -webkit-line-clamp: 1;
            height: 24px;
            line-height: 23px;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            max-width: 80px;
        }
        .dgtass-category a, .dgtass-author{
            color: var(--secondary-text-color);
            font-size: 0.9em;
        }
        .archive-content .dgtass-item,
        .digitalasset-list .dgtass-item{
            background-color: #1e1e23;
            border-radius: 15px;
            overflow: hidden;
        }

        .dgtass-item .dgtass-available{
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--secondary-text-color);
            font-size: 1em;
        }

        .dgtass-item .dgtass-thumbnail .dgtass-thumbnail-image,
        .dgtass-item .dgtass-thumbnail .dgtass-thumbnail-video{
            position: relative;
            display: block;
            width: 100%;
            padding-top: 100%;
            height: inherit;
            border-radius: 0;
            overflow: hidden;
        }
        
        .dgtass-item .dgtass-thumbnail .dgtass-thumbnail-image picture,
        .dgtass-item .dgtass-thumbnail .dgtass-thumbnail-video video{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
			object-fit:cover;
        }
        .dgtass-item .dgtass-thumbnail .dgtass-thumbnail-image picture img,
        .dgtass-item .dgtass-thumbnail .dgtass-thumbnail-video video source
		{
            min-height: 100%;
            min-width: 100%;
            position: relative;
            display: inherit;
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
        .haru-single-digitalasset .single-content .single-wrapper article .single-digitalasset-main .digitalasset-content .post-social-share {
            text-align: center;
            margin-bottom: 65px;
        }
                
        .haru-single-digitalasset .single-content .single-wrapper article .single-digitalasset-main .digitalasset-content .post-social-share .social-share-wrapper .social-share {
            list-style: none;
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .haru-single-digitalasset .single-content .single-wrapper article .single-digitalasset-main .digitalasset-content .post-social-share .social-share-wrapper .social-share li {
            display: inline-block;
            margin-left: 15px;
        }

        .haru-single-digitalasset .single-content .single-wrapper article .single-digitalasset-main .digitalasset-content .post-social-share .social-share-wrapper .social-share li.social-label {
            display: none;
        }

        .haru-single-digitalasset .single-content .single-wrapper article .single-digitalasset-main .digitalasset-content .post-social-share .social-share-wrapper .social-share li a {
            color: #fd6500;
            display: inline-block;
            font-family: "Playfair Display";
            font-weight: 700;
            font-size: 16px;
            text-transform: uppercase;
            text-align: center;
            width: 45px;
            height: 45px;
            line-height: 40px;
            border: 2px solid rgba(224, 224, 224, 0.3);
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            border-radius: 50%;
            -webkit-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
        }

        .haru-single-digitalasset .single-content .single-wrapper article .single-digitalasset-main .digitalasset-content .post-social-share .social-share-wrapper .social-share li a:hover {
            background-color: #fd6500;
            border: 2px solid #fd6500;
            color: #fff;
            -webkit-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
        }
        #haru-content-main{
            background-color: #000;
        }
		.haru-single-digitalasset{
			margin-top: 50px;
		}
        .single-digitalasset-main .digitalasset-detail .digitalasset-title{
            margin-top: 0;
            font-size: 2.3em;
            color: #fff;
        }
        .single-digitalasset-main .digitalasset-detail .digitalasset-author h5{
            font-size: 1.2em;
            color: #aaa;
            margin-bottom: 40px;
        }
        .single-digitalasset-main .digitalasset-detail .digitalasset-price{
            margin-bottom: 30px;
        }
        .single-digitalasset-main .digitalasset-detail .digitalasset-price p{
            font-size: 1em;
            color: #828282;
            margin-bottom: 10px;
        }
        .single-digitalasset-main .digitalasset-detail .digitalasset-price span{
            font-size: 1.5em;
            color: #fff;
        }
        .single-digitalasset-main .digitalasset-detail .digitalasset-price span.syn{
            color: #828282;
        }
        .single-digitalasset-main .digitalasset-detail .digitalasset-available{
            margin-bottom: 20px;
        }
        .single-digitalasset-main .digitalasset-detail .digitalasset-des p.des_lable{
            font-size: 1em;
            font-weight: bold;
        }
        .single-digitalasset-main .digitalasset-detail .digitalasset-des > *{
            color: #aaa;
        }

        .single-digitalasset-main .digitalasset-detail .digitalasset-find-more{
            margin-top: 30px;
        }
		
		.thong_tin_them table{
			width:100%;
		}
		
		.thong_tin_them table tr td{
			vertical-align: text-top;
			border: 0px;
			padding-left: 0px;
			padding-right: 0px;
		}
		.thong_tin_them table tr, .thong_tin_them table{
			border: 0px;
		}

        @media(max-width: 1200px){
            .digitalasset-list.columns-4{
                gap: 30px;
            }
            .digitalasset-list.columns-5{
                gap: 15px;
            }
			.digitalasset-list.columns-4 > .digitalasset-item{
				width: calc(27% - 44px);
			}
            .digitalasset-list.columns-5 > .digitalasset-item{
                width: calc(25% - 60px);
            }
			.dgtass-name .dgtass-title a, .dgtass-price{
				font-size: 1em;
			}
			.dgtass-category a, .dgtass-author{
				font-size: 0.8em;
			}
        }
        @media(max-width: 1000px){
            .digitalasset-list.columns-4{
                gap: 40px;
            }
            .digitalasset-list.columns-4 > .digitalasset-item{
                width: calc(33.333% - 30px);
            }
            .digitalasset-list.columns-3{
                gap: 40px;
            }
            .digitalasset-list.columns-3 > .digitalasset-item{
                width: calc(33.333% - 30px);
            }

            .digitalasset-list.columns-5{
                gap: 40px;
                justify-content: center;
            }
            .digitalasset-list.columns-5 > .digitalasset-item{
                width: calc(33.333% - 30px);
            }
        }
        @media(max-width: 768px){
            .single-digitalasset-main .digitalasset-description{
                margin-top: 30px;
            }
            .haru-single-digitalasset .single-content .single-wrapper article .single-digitalasset-main .digitalasset-content .post-social-share {
                margin-bottom: 35px;
            }
            .haru-single-digitalasset .single-content .single-wrapper article .single-digitalasset-main .digitalasset-content .post-social-share .social-share-wrapper .social-share li a {
                font-size: 14px;
                width: 35px;
                height: 35px;
                line-height: 32px;
            }

            .digitalasset-list.columns-3{
                gap: 35px;
            }
            .digitalasset-list.columns-3 > .digitalasset-item{
                width: calc(50% - 17.5px);
            }
            .digitalasset-list.columns-4{
                gap: 35px;
            }
            .digitalasset-list.columns-4 > .digitalasset-item{
                width: calc(50% - 17.5px);
            }
            .digitalasset-list.columns-5{
                gap: 35px;
                justify-content: flex-start;
            }
            .digitalasset-list.columns-5 > .digitalasset-item{
                width: calc(50% - 17.5px);
            }
            .dgtass-meta{
                padding: 10px;
            }
            .dgtass-title{
                font-size: 1.2rem;
            }
            .dgtass-author{
                font-size: 1.2rem;   
            }
            .dgtass-price{
                font-size: 1.2rem;
            }
            .dgtass-category{
                height: 23px;
				line-height: 19px;
            }
			.dgtass-info{
				    grid-row-gap: 0.2rem;
			}
			#digital-filter-form select{
				padding: 10px 10px 15px 15px;
			}
        }
        @media(max-width: 480px){
            .digitalasset-list.columns-2{
                gap: 20px;
            }
            .digitalasset-list.columns-2 > .digitalasset-item{
                width: 100%;
            }
            .digitalasset-list.columns-3{
                column-gap: 0px;
                row-gap: 20px;
            }
            .digitalasset-list.columns-3 > .digitalasset-item{
                width: 100%;
            }
            .digitalasset-list.columns-4{
                column-gap: 0px;
                row-gap: 20px;
            }
            .digitalasset-list.columns-4 > .digitalasset-item{
                width: 100%;
            }
            .digitalasset-list.columns-5{
                column-gap: 0px;
                row-gap: 20px;
            }
            .digitalasset-list.columns-5 > .digitalasset-item{
                width: 100%;
            }
            .dgtass-name{
                width: 50%;
            }
            .dgtass-category{
                max-width: unset;
            }
        }
    </style>
    <?php
}

add_action('wp_footer','digital_js');
function digital_js(){
    ?>
    <script type="text/javascript">

        function submitFormFilterSortDigitalAsset() {
            document.getElementById("digital-filter-form").submit();
        }

        const videos = document.querySelectorAll('.dgtass-thumbnail-video video');

        videos.forEach(video => {
            video.addEventListener('mouseenter', () => {
                video.play();
            });
        
            video.addEventListener('mouseleave', () => {
                video.pause();
                video.currentTime = 0;
            });
        });

    </script>
    <?php
}

function isMobileDevice() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $mobileKeywords = array('Mobile', 'Android', 'iPhone', 'iPad', 'Windows Phone');

    foreach ($mobileKeywords as $keyword) {
        if (stripos($userAgent, $keyword) !== false) {
            return true;
        }
    }

    return false;
}


// Thêm trường tùy chỉnh kiểu tải lên ảnh cho taxonomy "digitalasset_category"
function add_taxonomy_image_field() {
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="category_image">Hình ảnh danh mục</label></th>
        <td>
            <div class="form-field term-thumbnail-wrap">
                <input type="hidden" id="taxonomy-image" name="digitalasset_category_image" class="taxonomy-image" value="">
                <div id="taxonomy-image-preview"></div>
                <p>
                    <input type="button" class="button button-secondary taxonomy-image-upload" value="<?php _e('Upload Image', 'text-domain'); ?>">
                    <input type="button" class="button button-secondary taxonomy-image-remove" value="<?php _e('Remove Image', 'text-domain'); ?>">
                </p>
            </div>
        </td>
    </tr>
    <script>
        jQuery(document).ready(function($) {
            // Xử lý sự kiện khi nhấp nút "Upload Image"
            $('.taxonomy-image-upload').on('click', function() {
                var imageUploader = wp.media({
                    title: '<?php _e('Select or Upload Image', 'text-domain'); ?>',
                    button: {
                        text: '<?php _e('Use Image', 'text-domain'); ?>'
                    },
                    multiple: false
                }).on('select', function() {
                    var attachment = imageUploader.state().get('selection').first().toJSON();
                    $('#taxonomy-image').val(attachment.url);
                    $('#taxonomy-image-preview').html('<img src="' + attachment.url + '" alt="" style="max-width:100%;">');
                }).open();
            });

            // Xử lý sự kiện khi nhấp nút "Remove Image"
            $('.taxonomy-image-remove').on('click', function() {
                $('#taxonomy-image').val('');
                $('#taxonomy-image-preview').html('');
            });

        });
		
    </script>
    <?php
}
add_action('digitalasset_category_add_form_fields', 'add_taxonomy_image_field');

// Hiển thị hình ảnh đã lưu trong trang chỉnh sửa taxonomy
function edit_taxonomy_image_field($term) {
    $image_url = get_term_meta($term->term_id, 'digitalasset_category_image', true);
    ?>
    <tr class="form-field term-thumbnail-wrap">
        <th scope="row"><?php _e('Taxonomy Image', 'text-domain'); ?></th>
        <td>
            <input type="hidden" id="taxonomy-image" name="digitalasset_category_image" class="taxonomy-image" value="<?php echo esc_attr($image_url); ?>">
            <div id="taxonomy-image-preview">
                <?php if (!empty($image_url)) : ?>
                    <img src="<?php echo esc_url($image_url); ?>" alt="" style="max-width:100%;">
                <?php endif; ?>
            </div>
            <p>
                <input type="button" class="button button-secondary taxonomy-image-upload" value="<?php _e('Upload Image', 'text-domain'); ?>">
                <input type="button" class="button button-secondary taxonomy-image-remove" value="<?php _e('Remove Image', 'text-domain'); ?>">
            </p>
        </td>
    </tr>
    <script>
        jQuery(document).ready(function($) {
            // Xử lý sự kiện khi nhấp nút "Upload Image"
            $('.taxonomy-image-upload').on('click', function() {
                var imageUploader = wp.media({
                    title: '<?php _e('Select or Upload Image', 'text-domain'); ?>',
                    button: {
                        text: '<?php _e('Use Image', 'text-domain'); ?>'
                    },
                    multiple: false
                }).on('select', function() {
                    var attachment = imageUploader.state().get('selection').first().toJSON();
                    $('#taxonomy-image').val(attachment.url);
                    $('#taxonomy-image-preview').html('<img src="' + attachment.url + '" alt="" style="max-width:100%;">');
                }).open();
            });

            // Xử lý sự kiện khi nhấp nút "Remove Image"
            $('.taxonomy-image-remove').on('click', function() {
                $('#taxonomy-image').val('');
                $('#taxonomy-image-preview').html('');
            });

        });
    </script>
    <?php
}
add_action('digitalasset_category_edit_form_fields', 'edit_taxonomy_image_field', 10, 2);

// Lưu dữ liệu của trường tùy chỉnh khi tạo hoặc chỉnh sửa taxonomy
function save_taxonomy_image_field($term_id) {
    if (isset($_POST['digitalasset_category_image'])) {
        $image = sanitize_text_field($_POST['digitalasset_category_image']);
        update_term_meta($term_id, 'digitalasset_category_image', $image);
    }
}
add_action('created_digitalasset_category', 'save_taxonomy_image_field');
add_action('edited_digitalasset_category', 'save_taxonomy_image_field');

// Hiển thị ảnh của taxonomy "digitalasset_category"
function display_taxonomy_image($term_id) {
    $image = get_term_meta($term_id, 'digitalasset_category_image', true);
    if (!empty($image)) {
        echo '<img src="' . esc_url($image) . '" alt="" style="max-width:100%;">';
    }
}

// Add custom WYSIWYG editor for a specific taxonomy
function digitalasset_category_editor($term, $taxonomy) {
    // Check if it's the taxonomy you want
    if ($taxonomy === 'digitalasset_category') {
        $content = get_term_meta($term->term_id, 'custom_editor_content', true);

		?>		
		<script src="https://cdn.ckeditor.com/4.22.1/full-all/ckeditor.js"></script>

		<tr class="form-field term-thumbnail-wrap">
			<th scope="row"><?php _e('Thông tin thêm', 'text-domain'); ?></th>
			<td>
				<textarea id="editor" name="custom_editor_content"><?=$content?></textarea>
			</td>
		</tr>
		<script>
			CKEDITOR.replace( 'editor' );
		</script>
		<?php
    }
}

// Save the WYSIWYG content when the term is updated
function save_digitalasset_category_editor($term_id) {
    if (isset($_POST['custom_editor_content'])) {
        update_term_meta($term_id, 'custom_editor_content', $_POST['custom_editor_content']);
    }
}

// Hook the functions to the specific taxonomy edit screen
add_action('edited_digitalasset_category', 'save_digitalasset_category_editor', 10, 2);
add_action('digitalasset_category_edit_form_fields', 'digitalasset_category_editor', 10, 2);


function load_media_files() {
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'load_media_files' );