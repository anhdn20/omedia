/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

(function($) {
    "use strict";
    var HaruPortfolio = {
        init: function() {
            HaruPortfolio.shortcodePortfolioInit();
            HaruPortfolio.shortcodePortfolioLoadMoreAjax();
            // HaruPortfolio.registerPrettyPhoto();
            HaruPortfolio.shortcodePortfolioPopup();
        },
        shortcodePortfolioInit: function() {
            $('.portfolio-shortcode-wrap').each(function() {
                var $this           = $(this);
                var $sc_id          = $this.attr('data-sc-id');
                var $container      = $('#portfolio-' + $sc_id, $this);
                var $loadmore_wrap  = $this.find('.portfolio-loadmore-wrap');
                var $layoutMode     = 'fitRows';
                // Layout mode
                if ( $(this).hasClass('masonry') || $(this).hasClass('packery') ) {
                    $layoutMode = 'packery'; // masonry doesn' work?
                }
                // For packery image size
                if ( $this.hasClass('packery') ) {
                    var $column           = $this.attr('data-column');
                    var $padding          = $this.attr('data-padding');
                }

                // First load items
                $container.imagesLoaded(function () {
                    $container.isotope({
                        itemSelector: '.portfolio-item',
                        layoutMode: $layoutMode
                    }).isotope('layout');
                    // Packery
                    if ( $this.hasClass('packery') ) {
                        HaruPortfolio.packeryPadding($this, $padding, $column);
                    }
                });

                // Filter items
                var $filter_style = $this.attr('data-filter-style');
                var $tab_container = $('.portfolio-tabs', $this);
                $('.haru-button', $tab_container).off().on('click', function() {
                    // Isotope filter
                    if ( $filter_style == 'filter-isotope' ) {
                        $('.haru-button', $tab_container).removeClass('active');
                        $('li', $tab_container).removeClass('active');
                        $(this).addClass('active');
                        $(this).parent().addClass('active');

                        var filter  = $(this).attr('data-filter');
                        $container.isotope({ 
                            filter: filter
                        });
                        $container.imagesLoaded(function () {
                            $container.isotope('layout');
                        });
                    } else {
                        var l                  = Ladda.create(this);
                        l.start();

                        $('.haru-button', $tab_container).removeClass('active');
                        $('li', $tab_container).removeClass('active');
                        $(this).addClass('active');
                        $(this).parent().addClass('active');

                        var $thumbnail        = $(this).attr('data-thumbnail');
                        var $sc_id            = $(this).attr('data-sc-id');
                        var $portfolio_title  = $(this).attr('data-portfolio-title');
                        var $hover_style      = $(this).attr('data-hover-style');
                        var $column           = $(this).attr('data-column');
                        var $data_source      = $(this).attr('data-source');
                        var $category         = $(this).attr('data-category');
                        var $portfolio_ids    = $(this).attr('data-portfolio-ids');
                        var $portfolio_tag    = $(this).attr('data-tag');
                        var $data_item        = $(this).attr('data-item');
                        var $data_show_paging = $(this).attr('data-show-paging');
                        var $order            = $(this).attr('data-order');
                        var $current_page     = $(this).attr('data-current-page');
                        var $padding          = $(this).attr('data-padding');
                        
                        var $filter_by        = $(this).attr('data-filter-by');
                        
                        $.ajax({
                            url: haru_framework_ajax_url,
                            data: ({
                                action: 'haruframework_portfolio_filter_ajax', 
                                sc_id: $sc_id,
                                thumbnail: $thumbnail,
                                portfolio_title: $portfolio_title,
                                hover_style: $hover_style,
                                columns: $column,
                                data_source: $data_source,
                                category: $category,
                                portfolio_ids: $portfolio_ids, 
                                portfolio_tag: $portfolio_tag,
                                item: $data_item,
                                show_paging: $data_show_paging,
                                order: $order,
                                current_page: $current_page,
                                padding: $padding
                            }),
                            success: function(data) {
                                l.stop();

                                var $items = $('.portfolio-item',data).hide();
                                $container.empty();

                                // console.log($items);
                                // console.log($container);
                                // console.log(data);

                                if ( $data_show_paging == '1') {
                                    $loadmore_wrap.empty();
                                    // if ( $('.portfolio-loadmore-wrap',data).length > 0 ) {
                                        var $loadButton = $('.load-more-ajax',data);
                                        $loadmore_wrap.append($loadButton);
                                    // }
                                }

                                // $container.append($items);
                                $container.isotope();

                                $items.imagesLoaded(function() {
                                    $items.fadeIn(); // fade in when ready
                                    // $container.isotope('appended', $items);
                                    $container.append($items).isotope('appended', $items);
                                    // setTimeout(function() {
                                        $container.isotope('layout');
                                    // }, 200);

                                    HaruPortfolio.init();
                                });
                            },
                            error:function(){
                                // Do something
                            }
                        });
                    }

                });

                // Loadmore items
                $('.portfolio-load-more', $this).off().on('click', function(event) {
                    event.preventDefault();

                    var l                  = Ladda.create(this);
                    l.start();

                    var $self = $(this);
                    var link = $(this).attr('data-href');
                    var contentWrapper = $('.portfolio-wrapper', $this); // parent element of .item
                    var element = '.portfolio-item'; // .item

                    $.get(link, function(data) {
                        var next_href = $('.portfolio-load-more', data).attr('data-href');
                        var $newElems = $(element, data).css({
                            opacity: 0
                        });

                        contentWrapper.append($newElems);
                        $newElems.imagesLoaded(function() {
                            l.stop();

                            $newElems.animate({
                                opacity: 1
                            });

                            contentWrapper.isotope('appended', $newElems);
                            setTimeout(function() {
                                contentWrapper.isotope('layout');
                            }, 400);

                            HaruPortfolio.init();
                            // Packery
                            if ( $this.hasClass('packery') ) {
                                HaruPortfolio.packeryPadding($this, $padding, $column);
                            }
                        });


                        if (typeof(next_href) == 'undefined') {
                            $self.remove();
                        } else {
                            $self.attr('data-href', next_href);
                        }
                    });
                });

                // Window resize
                $(window).resize(function(){
                    setTimeout(function(){
                        HaruPortfolio.init();
                        if ( $this.hasClass('packery') ) {
                            HaruPortfolio.packeryPadding($this, $padding, $column);
                        }
                    }, 200);
                });
            });
        },
        shortcodePortfolioLoadMore:function() {

        },
        shortcodePortfolioLoadMoreAjax: function() {
            $('.load-more-ajax', '.portfolio-loadmore-wrap').off().on('click', function(e) {
                var l                  = Ladda.create(this);
                l.start();

                var $thumbnail        = $(this).attr('data-thumbnail');
                var $portfolio_title  = $(this).attr('data-portfolio-title');
                var $hover_style      = $(this).attr('data-hover-style');
                var $column           = $(this).attr('data-column');
                var $data_source      = $(this).attr('data-source');
                var $category         = $(this).attr('data-category');
                var $portfolio_ids    = $(this).attr('data-portfolio-ids');
                var $portfolio_tag    = $(this).attr('data-tag');
                var $data_item        = $(this).attr('data-item');
                var $data_show_paging = $(this).attr('data-show-paging');
                var $order            = $(this).attr('data-order');
                var $current_page     = $(this).attr('data-current-page');
                var $padding          = $(this).attr('data-padding');
                
                var $filter_by        = $(this).attr('data-filter-by');

                $.ajax({
                    url: haru_framework_ajax_url,
                    data: ({
                        action: 'haruframework_portfolio_filter_ajax_loadmore', 
                        thumbnail: $thumbnail,
                        portfolio_title: $portfolio_title,
                        hover_style: $hover_style,
                        columns: $column,
                        data_source: $data_source,
                        category: $category,
                        portfolio_ids: $portfolio_ids, 
                        portfolio_tag: $portfolio_tag,
                        item: $data_item,
                        show_paging: $data_show_paging,
                        order: $order,
                        current_page: $current_page,
                        padding: $padding
                    }),
                    success: function(data) {
                        l.stop();

                        var $items = $('.portfolio-item',data).css({
                                        opacity: 0
                                    });

                        $('.portfolio-wrapper', '.portfolio-shortcode-wrap').append($items);

                        if ( $data_show_paging == '1') {
                        $('.portfolio-loadmore-wrap').empty();
                            var $loadButton = $('.load-more-ajax',data);
                            $('.portfolio-loadmore-wrap').append($loadButton);
                        }

                        $items.imagesLoaded(function() {
                            $items.animate({
                                opacity: 1
                            });

                            $('.portfolio-wrapper', '.portfolio-shortcode-wrap').isotope('appended', $items);
                            setTimeout(function() {
                                // alert(3);
                                $('.portfolio-wrapper', '.portfolio-shortcode-wrap').isotope('layout');
                            }, 400);

                            HaruPortfolio.init();
                        });
                    },
                    error:function(){
                        // Do something
                    }
                });
            });
            
        },
        registerPrettyPhoto: function() {
            // $("a[data-rel^='prettyPhoto']").prettyPhoto({
            //     hook: 'data-rel',
            //     theme: 'light_rounded',
            //     slideshow: 5000,
            //     deeplinking: false,
            //     social_tools: false
            // });
        },
        shortcodePortfolioPopup: function() {
            // https://codepen.io/saintjon/pen/KwvvVr
            $('.portfolio-item').each(function(){
                $(this).magnificPopup({
                    delegate: 'a.portfolio-gallery-popup',
                    gallery: {
                        enabled: true
                    },
                    type: 'image',
                    // other options
                    beforeOpen: function() {
                        this.st.mainClass = 'portfolio-popup';
                    }
                });
                // https://codepen.io/saintjon/pen/KwvvVr
                $(this).find('a.portfolio-video-popup').magnificPopup({
                    type: 'iframe',
                    iframe: {
                        markup: '<div class="mfp-iframe-scaler">'+
                                '<div class="mfp-close"></div>'+
                                '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
                                '<div class="mfp-title">Some caption</div>'+
                              '</div>'
                    },
                    callbacks: {
                        markupParse: function(template, values, item) {
                            values.title = item.el.attr('title');
                        },
                        beforeOpen: function() {
                            this.st.mainClass = 'portfolio-popup';
                        }
                    }
                });
            });
        },
        packeryPadding: function(element, $padding, $column) {
            if( element.hasClass('packery') && (typeof $padding !== 'undefined') && ($padding != 0) && ($(window).width() > 767) ) { // Use padding
                var portfolio_wrapper_width = element.find('.portfolio-wrapper').width();
                var padding_total = Number($column) * Number($padding) * 2;

                var portfolio_item_height = (portfolio_wrapper_width - padding_total) / Number($column);
                // Small squared

                // Landscape
                $(element).find('.portfolio-item.landscape').each(function() {
                    $(this).css({'height': portfolio_item_height});
                    $('.portfolio-thumbnail img',this).css({'height': portfolio_item_height});
                });
                // Portrait
                $(element).find('.portfolio-item.portrait').each(function() {
                    $(this).css({'height': (Number(portfolio_item_height) + Number($padding)) * 2 });
                    $('.portfolio-thumbnail img',this).css({'height': (Number(portfolio_item_height) + Number($padding)) * 2 });
                });
                // Big Squared
                $(element).find('.portfolio-item.big_squared').each(function() {
                    $(this).css({'height': (Number(portfolio_item_height) + Number($padding)) * 2 });
                    $('.portfolio-thumbnail img',this).css({'height': (Number(portfolio_item_height) + Number($padding)) * 2 });
                });
            }
        }
    }

    $(document).ready(function() {
        HaruPortfolio.init();
    });
})(jQuery);