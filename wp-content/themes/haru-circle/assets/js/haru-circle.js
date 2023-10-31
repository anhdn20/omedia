/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
 */
(function($) {
    "use strict";
    var HaruCircle = {
        init: function() {
            HaruCircle.base.init();
            HaruCircle.video.init();
            HaruCircle.actor.init();
            HaruCircle.director.init();
            HaruCircle.film.init();
            HaruCircle.filmSearch.init();
            HaruCircle.trailer.init();
            HaruCircle.blog.init();
        }
    };
    HaruCircle.base = {
        init: function() {
            HaruCircle.base.shortcodeImagesGallery();
            HaruCircle.base.shortcodeTeamMember();
            HaruCircle.base.shortcodeCarousel();
            HaruCircle.base.shortcodeTestimonial();
            HaruCircle.base.shortcodeCounter();
            HaruCircle.base.shortcodeProgressBar();
            HaruCircle.base.timeline();
            HaruCircle.base.singlePortfolioSlideshow();
            HaruCircle.base.singleCircleGalleryPopup();
        },
        shortcodeTeamMember: function() {
            $('.teammember-shortcode-wrapper').each(function() {
                if ($(this).hasClass('grid')) {
                    $(this).find('.team-item').matchHeight({
                        byRow: true
                    });
                }
            });
        },
        shortcodeCarousel: function() {
            $('.haru-carousel.owl-carousel').each(function(index, value) {
                var items = parseInt($(this).attr('data-items'));
                var margin = parseInt($(this).attr('data-margin'));
                var autoplay = $(this).attr('data-autoplay') == 'true' ? true : false;
                var slide_duration = parseInt($(this).attr('data-slide-duration'));

                $(this).owlCarousel({
                    items: items,
                    margin: margin,
                    loop: false,
                    center: false,
                    mouseDrag: true,
                    touchDrag: true,
                    pullDrag: true,
                    freeDrag: false,
                    stagePadding: 0,
                    merge: false,
                    mergeFit: true,
                    autoWidth: false,
                    startPosition: 0,
                    URLhashListener: false,
                    nav: true,
                    navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                    rewind: true,
                    navElement: 'div',
                    slideBy: 1,
                    dots: true,
                    dotsEach: false,
                    lazyLoad: false,
                    lazyContent: false,

                    autoplay: autoplay,
                    autoplayTimeout: slide_duration,
                    autoplayHoverPause: true,

                    smartSpeed: 250,
                    fluidSpeed: false,
                    autoplaySpeed: false,
                    navSpeed: false,
                    dotsSpeed: false,
                    dragEndSpeed: false,
                    responsive: {
                        0: {
                            items: 1
                        },
                        500: {
                            items: (items < 2) ? 1 : 2
                        },
                        768: {
                            items: (items < 3) ? 2 : 3
                        },
                        991: {
                            items: items
                        },
                        1200: {
                            items: items
                        },
                        1300: {
                            items: items
                        }
                    },
                    responsiveRefreshRate: 200,
                    responsiveBaseElement: window,
                    video: false,
                    videoHeight: false,
                    videoWidth: false,
                    animateOut: false,
                    animateIn: false,
                    fallbackEasing: 'swing',

                    info: false,

                    nestedItemSelector: false,
                    itemElement: 'div',
                    stageElement: 'div',

                    navContainer: false,
                    dotsContainer: false
                });
            });
        },
        shortcodeTestimonial: function() {
            $('.testimonial-shortcode-wrapper').each(function() {
                var $this = $(this);
                var autoplay = $(this).attr('data-autoplay') == 'true' ? true : false;
                var slide_duration = parseInt($(this).attr('data-slide-duration'));

                if ($this.hasClass('carousel')) {
                    $this.find('.slider-for').slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: true,
                        fade: false,
                        autoplay: autoplay,
                        autoplaySpeed: slide_duration,
                        asNavFor: $('.slider-nav', $this)
                    });
                    $this.find('.slider-nav').slick({
                        slidesToShow: 5,
                        slidesToScroll: 1,
                        arrows: false,
                        asNavFor: $('.slider-for', $this),
                        dots: false,
                        centerMode: true,
                        centerPadding: '0px',
                        focusOnSelect: true,
                        responsive: [{
                                breakpoint: 991,
                                settings: {
                                    slidesToShow: 3
                                }
                            },
                            {
                                breakpoint: 767,
                                settings: {
                                    slidesToShow: 3
                                }
                            }
                        ]
                    });
                }
                // Carousel 2, 3
                if ($this.hasClass('carousel_2') || $this.hasClass('carousel_3')) {
                    $this.find('.slider-for').slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: true,
                        autoplay: autoplay,
                        autoplaySpeed: slide_duration,
                        fade: false
                    });
                }
            });
        },
        shortcodeCounter: function() {
            $('.counter-shortcode-wrapper').each(function() {
                var $this = $(this);

                // Appear
                if (!$(".gr-animated").length) return;

                $(".gr-animated").appear();

                $(document.body).on("appear", ".gr-animated", function() {
                    $(this).addClass("go");
                });

                $(document.body).on("disappear", ".gr-animated", function() {
                    $(this).removeClass("go");
                });

                // Counter
                if (!$(".gr-number-counter").length) return;
                $(".gr-number-counter").appear(); // require jquery-appear

                $('body').on("appear", ".gr-number-counter", function() {
                    var counter = $(this);
                    if (!counter.hasClass("count-complete")) {
                        counter.countTo({
                            speed: 1500,
                            refreshInterval: 100,
                            onComplete: function() {
                                counter.addClass("count-complete");
                            }
                        });
                    }
                });

                $('body').on("disappear", ".gr-number-counter", function() {
                    $(this).removeClass("count-complete");
                });
            });
        },
        shortcodeProgressBar: function() {
            // $( window ).scroll(function() {   
            //     if ( $( window ).scrollTop() > 10 ) {  // scroll down abit and get the action   
                    $(".progress-bar").each(function() {
                        var each_bar_width = $(this).attr('aria-valuenow');
                        $(this).width(each_bar_width + '%');
                    });
            //     }
            // });
        },
        timeline: function() {
            $('.timeline-shortcode-wrap.carousel').each(function() {
                var timeline_content    = $(this).find("#timeline-content");
                var timeline_thumb    = $(this).find("#timeline-thumb");

                timeline_content.slick();
                timeline_thumb.slick();            
            });
        },
        shortcodeImagesGallery: function() {
            $('.images-gallery-shortcode-wrapper').each(function() {
                var $this = $(this);

                // Slick
                if ($this.hasClass('slick')) {
                    $this.find('.images-list').slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: true,
                        infinite: true,
                        centerMode: true,
                        centerPadding: '0px',
                        variableWidth: true,
                        responsive: [
                            {
                                breakpoint: 991,
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1
                                }
                            },
                            {
                                breakpoint: 767,
                                settings: {
                                    variableWidth: true
                                }
                            }
                        ]
                    });
                }
                if ($this.hasClass('slick_2')) {
                    $this.find('.images-list').slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: true,
                        infinite: true,
                        centerMode: true,
                        centerPadding: '20%',
                        variableWidth: false,
                        responsive: [
                            {
                                breakpoint: 991,
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1,
                                    variableWidth: false,
                                    centerPadding: '10%',
                                }
                            },
                            {
                                breakpoint: 767,
                                settings: {
                                    variableWidth: false,
                                    centerPadding: '10%',
                                }
                            }
                        ]
                    });
                }
            });
        },
        beforeAjax: function() {
            $('.haru-ajax-overflow').addClass('active');
        },
        afterAjax: function() {
            $('.haru-ajax-overflow').removeClass('active');
        },
        singlePortfolioSlideshow: function() {
            $('.single-portfolio-slideshow').each(function() {
                var $this = $(this);

                // Slick
                $this.slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: true,
                    infinite: true,
                    centerMode: true,
                    centerPadding: '20%',
                    variableWidth: false,
                    responsive: [
                        {
                            breakpoint: 991,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                centerPadding: '10%',
                            }
                        },
                        {
                            breakpoint: 767,
                            settings: {
                                variableWidth: false,
                                centerPadding: '10%',
                            }
                        }
                    ]
                });
            });
        },
        singleCircleGalleryPopup: function() {
            $('.video-images, .actor-images, .director-images').magnificPopup({
                delegate: 'a',
                gallery: {
                    enabled: true
                },
                type: 'image'
                // other options
            });
        },
    };

    HaruCircle.video = {
        init: function() {
            HaruCircle.video.thumbnailHover();
            HaruCircle.video.shortcodeVideo(); // Video gallery work
            HaruCircle.video.shortcodeVideoAjax();
            HaruCircle.video.shortcodeVideoModal(); // Video single
            HaruCircle.video.displayVideoPlayerDirect();
            HaruCircle.video.videoLoadMore();
            HaruCircle.video.videoInfiniteScroll();
            HaruCircle.video.singleVideoGallery();
        },
        thumbnailHover: function() {
            $('.video-thumbnail-slideshow').each(function(){
                var $self = $(this).parents('.video-item');
                var speed = $(this).data('speed');
                var currentIndex = 0,
                    items = $('img', $self),
                    itemAmt = items.length;

                if ( itemAmt == 1 ) {
                    return;
                }

                function cycleItems(currentIndex) {
                    var item = $('img', $self).eq(currentIndex);
                    items.hide();
                    item.css('display','block'); // item.fadeIn();
                }

                $self.mouseenter(function(){
                    var autoSlide = setInterval(function() {
                        currentIndex += 1;
                        if ( currentIndex > itemAmt - 1 ) {
                            currentIndex = 0;
                            // Go to first & stop
                            clearInterval(autoSlide);
                        }
                        cycleItems(currentIndex);
                    }, speed);

                    $self.mouseleave(function(){
                        clearInterval(autoSlide);
                        // Show first thumb
                        $.each(items, function( index, item ) {
                            if ( item == items[0] ) {
                                $(item).css('display','block');
                            } else {
                                $(item).hide();
                            }
                        });
                    });
                });
            });

            $('.video-thumbnail-video').each(function(){
                var $self = $(this).parents('.video-item');

                $self.hover(function(){
                    let video = $('video', this).get(0);
                    video.play();
                    video.muted = true;
                }, function() {
                    let video = $('video', this).get(0);
                    video.pause();
                });
            });
        },
        shortcodeVideo: function() {
            var default_filter = [];
            var array_filter = []; // Push filter to an array to process when don't have filter

            $('.video-shortcode-wrapper').each(function(index, value) {
                // Process filter each shortcode
                $(this).find('.video-filter li').first().find('a').addClass('selected');
                default_filter[index] = $(this).find('.video-filter li').first().find('a').attr('data-option-value');

                var self = $(this);
                var $container = $(this).find('.video-list'); // parent element of .item
                var $filter = $(this).find('.video-filter a');
                var masonry_options = {
                    'gutter': 0
                };

                array_filter[index] = $filter;

                // Add to process products layout style
                var layoutMode = 'fitRows';
                if (($(this).hasClass('masonry'))) {
                    var layoutMode = 'masonry';
                }

                for (var i = 0; i < array_filter.length; i++) {
                    if (array_filter[i].length == 0) {
                        default_filter = '';
                    }
                    $container.isotope({
                        itemSelector: '.video-item', // .item
                        transitionDuration: '0.4s',
                        masonry: masonry_options,
                        layoutMode: layoutMode,
                        filter: default_filter[i]
                    });
                }

                imagesLoaded(self, function() {
                    $container.isotope('layout');

                    HaruCircle.video.shortcodeVideoModal();
                    HaruCircle.video.thumbnailHover();
                });

                $(window).resize(function() {
                    $container.isotope('layout');
                });

                $filter.click(function(e) {
                    e.stopPropagation();
                    e.preventDefault();

                    var $this = $(this);
                    // Don't proceed if already selected
                    if ($this.hasClass('selected')) {
                        return false;
                    }
                    var filters = $this.closest('ul');
                    filters.find('.selected').removeClass('selected');
                    $this.addClass('selected');

                    var options = {
                            layoutMode: layoutMode,
                            transitionDuration: '0.4s',
                            packery: {
                                horizontal: true
                            },
                            masonry: masonry_options
                        },
                        key = filters.attr('data-option-key'),
                        value = $this.attr('data-option-value');
                    value = value === 'false' ? false : value;
                    options[key] = value;

                    $container.isotope(options);
                });
            });
        },
        shortcodeVideoAjax: function() {
            var video_ajax_category_data = []; // Use this for video ajax category shortcode

            $('.video-shortcode-ajax').each(function() {
                var $this = $(this);

                $this.find('.video-filter .filter-item').on('click', function() {
                    // Check if already click or loading
                    if ( $(this).hasClass('selected') || $(this).parents('.video-shortcode-ajax').find('.video-list').hasClass('loading') ){
                        return;
                    }

                    var element         = $(this).parents('.video-shortcode-ajax');
                    var category        = $(this).data('category');
                    var atts            = element.data('atts');
                    var is_filter_all   = $(this).hasClass('filter-all') ? 1 : 0;
                    var paging          = $(this).parents('.video-shortcode-ajax').find('.videos-ajax-paging');
                    

                    element.find('.video-filter .filter-item').removeClass('selected');
                    $(this).addClass('selected');

                    // Check cache
                    var tab_data_index = category.toString().split(',').join('-');
                    if ( video_ajax_category_data[tab_data_index] != undefined ){
                        element.find('.video-list .videos').remove();
                        element.find('.videos-ajax-paging').remove();
                        element.find('.video-list').append( video_ajax_category_data[tab_data_index] );

                        HaruCircle.video.shortcodeVideoAjaxGrid( element );
                        HaruCircle.video.shortcodeVideoAjaxLoadMore( element );
                        HaruCircle.video.shortcodeVideoModal();
                        HaruCircle.video.thumbnailHover();

                        return;
                    }

                    // Load content via ajax
                    element.find('.video-list').addClass('loading');

                    $.ajax({
                        type : "POST",
                        timeout : 30000,
                        url : haru_framework_ajax_url,
                        data : {
                            action: 'haru_get_video_ajax', 
                            atts: atts, 
                            category: category, 
                            is_filter_all: is_filter_all
                        },
                        error: function(xhr,err) {
                            console.log('Have something wrong! Please try again!');
                        },
                        success: function(response) {
                            if ( response ) {       
                                element.find('.video-list .videos').remove();
                                element.find('.videos-ajax-paging').remove();
                                element.find('.video-list').append( response ).find('.video-item').css( 'opacity', 0 ).animate({ opacity: 1 }, 500);

                                /* Save cache */
                                video_ajax_category_data[tab_data_index] = response;

                                /* Generate isotope */
                                if ( $this.hasClass('grid') ) {
                                    HaruCircle.video.shortcodeVideoAjaxGrid( element );
                                } 
                                if ( $this.hasClass('slider') ) { 
                                    // Do something
                                }

                                HaruCircle.video.shortcodeVideoModal();
                                HaruCircle.video.thumbnailHover();
                            }
                            element.find('.video-list').removeClass('loading');

                            HaruCircle.video.shortcodeVideoAjaxLoadMore( element );
                        }
                    });
                });

                // Click first tab when page load
                $('.video-shortcode-ajax').each(function() {
                    $(this).find('.video-filter .filter-item:first').trigger('click');
                });

            });
        },
        shortcodeVideoAjaxLoadMore: function( element ) {
            $('.video-ajax-load-more').off().on('click', function(e) {
                e.preventDefault();

                var element_paging  = $(this).parents('.videos-ajax-paging');
                var category        = $(this).data('category');
                var atts            = $(this).data('atts');
                var current_page    = $(this).data('current_page');
                var is_filter_all   = $(this).hasClass('filter-all') ? 1 : 0;

                $.ajax({
                    url: haru_framework_ajax_url,
                    type: "POST",
                    data: {
                        action: 'haru_video_ajax_loadmore',
                        atts: atts, 
                        category: category,
                        current_page: current_page
                    },
                    dataType: "html",
                    beforeSend: function() {
                        element_paging.prepend('<span class="ajax-button-loading fa fa-spinner fa-spin"></span>');
                        element_paging.addClass('loading');
                    }
                }).success(function(response) {
                    element_paging.removeClass('loading');

                    if ( response ) {
                        var paging_button = $(response).find('div.videos-ajax-paging .video-ajax-load-more');

                        var $items_response = $(response).find('div.video-item').css({
                            opacity: 0
                        });

                        element.find('.video-list .videos').append($items_response);
                        $items_response.imagesLoaded(function() {
                            $items_response.animate({
                                opacity: 1
                            });

                            element.find('.video-list .videos').isotope('appended', $items_response);
                            setTimeout(function() {
                                element.find('.video-list .videos').isotope('layout');
                            }, 400);

                            HaruCircle.video.shortcodeVideoModal();
                            HaruCircle.video.thumbnailHover();
                        });

                        element_paging.html(paging_button);
  
                        HaruCircle.video.shortcodeVideoAjaxLoadMore( element );
                        /* Save cache - Later */
                    }
                });
            });
        },
        shortcodeVideoAjaxGrid: function(element) {
            if ( element.find('.video-list .video-item').length > 0 ) {
                setTimeout(function(){
                    element.find('.video-list .videos').isotope({
                        itemSelector : '.video-item',
                        layoutMode: 'fitRows'
                    });
                    imagesLoaded(element, function() {
                        element.find('.video-list .videos').isotope('layout');
                    });
                }, 100);
            }
        },
        shortcodeVideoModal: function() {
            $('.view-video-button').off().on('click', function(e) {
                e.preventDefault();
                var video_id = $(this).data('id');
                var player_js = $(this).attr('data-player');
                var server = $(this).attr('data-server');

                $.ajax({
                    url: haru_framework_ajax_url,
                    type: "POST",
                    data: {
                        action: 'haru_video_modal',
                        video_id: video_id
                    },
                    dataType: "html",
                    beforeSend: function() {
                        HaruCircle.base.beforeAjax()
                    }
                }).success(function(result) {
                    HaruCircle.base.afterAjax();

                    $.magnificPopup.open({
                        type: "inline",
                        mainClass: 'mfp-zoom-in mfp-video-popup',
                        zoom: {
                            enabled: true, // By default it's false, so don't forget to enable it
                            duration: 300, // duration of the effect, in milliseconds
                            easing: 'ease-in-out', // CSS transition easing function
                            // The "opener" function should return the element from which popup will be zoomed in
                            // and to which popup will be scaled down
                            // By defailt it looks for an image tag:
                            opener: function(openerElement) {
                                // openerElement is the element on which popup was initialized, in this case its <a> tag
                                // you don't need to add "opener" option if this code matches your needs, it's defailt one.
                                // return openerElement.is('img') ? openerElement : openerElement.find('img');
                                return openerElement.is('video') ? openerElement : openerElement.find('video');
                            }
                        },
                        items: {
                            src: result
                        },
                        callbacks: {
                            open: function() {
                                HaruCircle.video.displayVideoPlayer(video_id, player_js, server);
                            }
                        }
                    });
                });
            });
        },
        isMobileOS: function() {
            var check = false;

            (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);

            return check;
        },
        displayVideoPlayer: function(video_id, player_js, server) {
            // Process for unmute video button
            if ( HaruCircle.video.isMobileOS() ) {
                $('body').addClass('haru-mobile');
            }

            // Do not use Player JS
            if( player_js == 'none' ) {
                setTimeout(function() {
                    // Youtube
                    if ( server == 'youtube' ) {
                        setTimeout(function() {
                            // Do something like autoplay
                        }, 300);
                    }
                    // Vimeo
                    if ( server == 'vimeo' ) {
                        setTimeout(function() {
                            // Do something like autoplay
                        }, 300);
                    }
                    // Local
                    if ( server == 'url' ) {
                        var player;

                        if (!player) {
                            player = $('#video-player').mediaelementplayer({
                                stretching: 'responsive',
                                features: ['playpause', 'progress', 'current', 'duration', 'volume', 'fullscreen'],
                                // pluginPath: "/path/to/shims/",
                                // When using jQuery's `mediaelementplayer`, an `instance` argument
                                // is available in the `success` callback
                                success: function(mediaElement, originalNode, instance) {
                                    // Hidden play button
                                    // $self.css('display', 'none');
                                    // Do something
                                    mediaElement.load();
                                    setTimeout(function() {
                                        mediaElement.play();
                                    }, 300);

                                    mediaElement.addEventListener('playing', function(){
                                        // Do something
                                        $('.video-mediaelement-unmute').on('click', function() {
                                            mediaElement.setMuted(false);
                                            mediaElement.setVolume(0.5);

                                            $(this).hide(300);
                                        });
                                    });
                                }
                            });
                        }
                    }
                }, 300);
            }
            // 
        },
        displayVideoPlayerDirect: function() {
            // Process for unmute video button
            if ( HaruCircle.video.isMobileOS() ) {
                $('body').addClass('haru-mobile');
            }

            $('.video-player-direct').off().on('click', function(e) {
                e.preventDefault();
                var $self = $(this);
                var player_js = $(this).attr('data-player');
                var server = $(this).attr('data-server');

                // Do not use Player JS
                if( player_js == 'none' ) {
                    // Youtube
                    if ( server == 'youtube' ) {
                        // Do something like autoplay
                        $self.parent().parent().addClass('played');
                    }
                    // Vimeo
                    if ( server == 'vimeo' ) {
                        // Do something like autoplay
                        $self.parent().parent().addClass('played');
                    }
                    // Dailymotion
                    if ( server == 'dailymotion' ) {
                        // Do something like autoplay
                        $self.parent().parent().addClass('played');
                    }
                    // Twitch
                    if ( server == 'twitch' ) {
                        // Do something like autoplay
                        $self.parent().parent().addClass('played');
                    }
                    // Dailymotion
                    if ( server == 'facebook' ) {
                        // Do something like autoplay
                        $self.parent().parent().addClass('played');
                    }
                    // Local
                    if ( server == 'url' ) {
                        setTimeout(function() {
                            var player;

                            if (!player) {
                                player = $('#video-player').mediaelementplayer({
                                    stretching: 'responsive',
                                    features: ['playpause', 'progress', 'current', 'duration', 'volume', 'fullscreen'],
                                    // pluginPath: "/path/to/shims/",
                                    // When using jQuery's `mediaelementplayer`, an `instance` argument
                                    // is available in the `success` callback
                                    success: function(mediaElement, originalNode, instance) {
                                        // Hidden play button
                                        $self.css('display', 'none');
                                        // Do something
                                        mediaElement.load();
                                        setTimeout(function() {
                                            mediaElement.play();
                                        }, 300);

                                        mediaElement.addEventListener('playing', function(){
                                            // Do something
                                            $('.video-mediaelement-unmute').on('click', function() {
                                                mediaElement.setMuted(false);
                                                mediaElement.setVolume(0.5);

                                                $(this).hide(300);
                                            });
                                        });
                                    }
                                });
                            }
                        }, 300);
                        setTimeout(function() {
                            $self.parent().parent().addClass('played');
                        }, 500);
                    }
                }
                // Use JS Player
            });
        },
        videoLoadMore: function() {
            $('.video-shortcode-paging-wrapper .video-load-more').off().on('click', function(event) {
                event.preventDefault();

                var $this = $(this).button('loading');
                var link = $(this).attr('data-href');
                var shortcode_wrapper = '.video-shortcode-wrapper';
                var contentWrapper = '.video-shortcode-wrapper .video-list'; // parent element of .item
                var element = '.video-item'; // .item

                $.get(link, function(data) {
                    var next_href = $('.video-load-more', data).attr('data-href');
                    var $newElems = $(element, data).css({
                        opacity: 0
                    });

                    $(contentWrapper).append($newElems);
                    $newElems.imagesLoaded(function() {
                        $newElems.animate({
                            opacity: 1
                        }, 0);

                        $(contentWrapper).isotope('appended', $newElems);
                        setTimeout(function() {
                            $(contentWrapper).isotope('layout');
                        }, 400);

                        HaruCircle.video.shortcodeVideoModal();
                        HaruCircle.video.thumbnailHover();
                    });


                    if (typeof(next_href) == 'undefined') {
                        $this.parent().remove();
                    } else {
                        $this.button('reset');
                        $this.attr('data-href', next_href);
                    }

                });
            });
        },
        videoInfiniteScroll: function() {
            var shortcode_wrapper = '.video-shortcode-wrapper';
            var contentWrapper = '.video-shortcode-wrapper .video-list'; // parent element of .item
            $('.video-list', shortcode_wrapper).infinitescroll({
                navSelector: "#infinite_scroll_button",
                nextSelector: "#infinite_scroll_button a",
                itemSelector: ".video-item", // .item
                loading: {
                    'selector': '#infinite_scroll_loading',
                    'img': haru_framework_theme_url + '/assets/images/ajax-loader.gif',
                    'msgText': 'Loading...',
                    'finishedMsg': ''
                }
            }, function(newElements, data, url) {
                var $newElems = $(newElements).css({
                    opacity: 0
                });
                $newElems.imagesLoaded(function() {
                    

                    $(contentWrapper).isotope('appended', $newElems);

                    $newElems.animate({
                        opacity: 1
                    }, 0 );

                    setTimeout(function() {
                        $(contentWrapper).isotope('layout');
                    }, 400);

                    HaruCircle.video.shortcodeVideoModal();
                    HaruCircle.video.thumbnailHover();
                });

            });
        },
        singleVideoGallery: function() {
            $('.haru-single-video .video-gallery').each(function(index, value) {
                var self = $(this);
                var $container = $(this).find('.video-images:not(.list)'); // parent element of .item
                var masonry_options = {
                    'gutter': 0
                };

                // Add to process products layout style
                var layoutMode = 'masonry';

                $container.isotope({
                    itemSelector: '.image-item', // .item
                    transitionDuration: '0.4s',
                    masonry: masonry_options,
                    layoutMode: layoutMode
                });

                imagesLoaded(self, function() {
                    $container.isotope('layout');
                });

                $(window).resize(function() {
                    $container.isotope('layout');
                });
            });
        }
    };

    // Actor
    HaruCircle.actor = {
        init: function() {
            HaruCircle.actor.shortcodeActor(); // Actor Grid
            HaruCircle.actor.actorLoadMore();
            HaruCircle.actor.actorInfiniteScroll();
            HaruCircle.actor.singleActorGallery();
        },
        shortcodeActor: function() {
            var default_filter = [];
            var array_filter = []; // Push filter to an array to process when don't have filter

            $('.actor-shortcode-wrapper').each(function(index, value) {
                // Process filter each shortcode
                $(this).find('.actor-filter li').first().find('a').addClass('selected');
                default_filter[index] = $(this).find('.actor-filter li').first().find('a').attr('data-option-value');

                var self = $(this);
                var $container = $(this).find('.actor-list'); // parent element of .item
                var $filter = $(this).find('.actor-filter a');
                var masonry_options = {
                    'gutter': 0
                };

                array_filter[index] = $filter;

                // Add to process products layout style
                var layoutMode = 'fitRows';
                if (($(this).hasClass('masonry'))) {
                    var layoutMode = 'masonry';
                }

                for (var i = 0; i < array_filter.length; i++) {
                    if (array_filter[i].length == 0) {
                        default_filter = '';
                    }
                    $container.isotope({
                        itemSelector: '.actor-item', // .item
                        transitionDuration: '0.4s',
                        masonry: masonry_options,
                        layoutMode: layoutMode,
                        filter: default_filter[i]
                    });
                }

                imagesLoaded(self, function() {
                    $container.isotope('layout');
                });

                $(window).resize(function() {
                    $container.isotope('layout');
                });

                $filter.click(function(e) {
                    e.stopPropagation();
                    e.preventDefault();

                    var $this = $(this);
                    // Don't proceed if already selected
                    if ($this.hasClass('selected')) {
                        return false;
                    }
                    var filters = $this.closest('ul');
                    filters.find('.selected').removeClass('selected');
                    $this.addClass('selected');

                    var options = {
                            layoutMode: layoutMode,
                            transitionDuration: '0.4s',
                            packery: {
                                horizontal: true
                            },
                            masonry: masonry_options
                        },
                        key = filters.attr('data-option-key'),
                        value = $this.attr('data-option-value');
                    value = value === 'false' ? false : value;
                    options[key] = value;

                    $container.isotope(options);
                });
            });
        },
        actorLoadMore: function() {
            $('.actor-shortcode-paging-wrapper .actor-load-more').off().on('click', function(event) {
                event.preventDefault();

                var $this = $(this).button('loading');
                var link = $(this).attr('data-href');
                var shortcode_wrapper = '.actor-shortcode-wrapper';
                var contentWrapper = '.actor-shortcode-wrapper .actor-list'; // parent element of .item
                var element = '.actor-item'; // .item

                $.get(link, function(data) {
                    var next_href = $('.actor-load-more', data).attr('data-href');
                    var $newElems = $(element, data).css({
                        opacity: 0
                    });

                    $(contentWrapper).append($newElems);
                    $newElems.imagesLoaded(function() {
                        $newElems.animate({
                            opacity: 1
                        });

                        $(contentWrapper).isotope('appended', $newElems);
                        setTimeout(function() {
                            $(contentWrapper).isotope('layout');
                        }, 400);

                        HaruCircle.actor.init();
                    });


                    if (typeof(next_href) == 'undefined') {
                        $this.parent().remove();
                    } else {
                        $this.button('reset');
                        $this.attr('data-href', next_href);
                    }

                });
            });
        },
        actorInfiniteScroll: function() {
            var shortcode_wrapper = '.actor-shortcode-wrapper';
            var contentWrapper = '.actor-shortcode-wrapper .actor-list'; // parent element of .item
            $('.actor-list', shortcode_wrapper).infinitescroll({
                navSelector: "#infinite_scroll_button",
                nextSelector: "#infinite_scroll_button a",
                itemSelector: ".actor-item", // .item
                loading: {
                    'selector': '#infinite_scroll_loading',
                    'img': haru_framework_theme_url + '/assets/images/ajax-loader.gif',
                    'msgText': 'Loading...',
                    'finishedMsg': ''
                }
            }, function(newElements, data, url) {
                var $newElems = $(newElements).css({
                    opacity: 0
                });
                $newElems.imagesLoaded(function() {
                    $newElems.animate({
                        opacity: 1
                    });

                    $(contentWrapper).isotope('appended', $newElems);
                    setTimeout(function() {
                        $(contentWrapper).isotope('layout');
                    }, 400);

                    HaruCircle.actor.init();
                });

            });
        },
        singleActorGallery: function() {
            $('.haru-single-actor .actor-gallery').each(function(index, value) {
                var self = $(this);
                var $container = $(this).find('.actor-images:not(.list)'); // parent element of .item
                var masonry_options = {
                    'gutter': 0
                };

                // Add to process products layout style
                var layoutMode = 'masonry';

                $container.isotope({
                    itemSelector: '.image-item', // .item
                    transitionDuration: '0.4s',
                    masonry: masonry_options,
                    layoutMode: layoutMode
                });

                imagesLoaded(self, function() {
                    $container.isotope('layout');
                });

                $(window).resize(function() {
                    $container.isotope('layout');
                });
            });
        }
    };

    // Director
    HaruCircle.director = {
        init: function() {
            HaruCircle.director.shortcodeDirector(); // Director Grid
            HaruCircle.director.directorLoadMore();
            HaruCircle.director.directorInfiniteScroll();
            HaruCircle.director.singleDirectorGallery();
        },
        shortcodeDirector: function() {
            var default_filter = [];
            var array_filter = []; // Push filter to an array to process when don't have filter

            $('.director-shortcode-wrapper').each(function(index, value) {
                // Process filter each shortcode
                $(this).find('.director-filter li').first().find('a').addClass('selected');
                default_filter[index] = $(this).find('.director-filter li').first().find('a').attr('data-option-value');

                var self = $(this);
                var $container = $(this).find('.director-list'); // parent element of .item
                var $filter = $(this).find('.director-filter a');
                var masonry_options = {
                    'gutter': 0
                };

                array_filter[index] = $filter;

                // Add to process products layout style
                var layoutMode = 'fitRows';
                if (($(this).hasClass('masonry'))) {
                    var layoutMode = 'masonry';
                }

                for (var i = 0; i < array_filter.length; i++) {
                    if (array_filter[i].length == 0) {
                        default_filter = '';
                    }
                    $container.isotope({
                        itemSelector: '.director-item', // .item
                        transitionDuration: '0.4s',
                        masonry: masonry_options,
                        layoutMode: layoutMode,
                        filter: default_filter[i]
                    });
                }

                imagesLoaded(self, function() {
                    $container.isotope('layout');
                });

                $(window).resize(function() {
                    $container.isotope('layout');
                });

                $filter.click(function(e) {
                    e.stopPropagation();
                    e.preventDefault();

                    var $this = $(this);
                    // Don't proceed if already selected
                    if ($this.hasClass('selected')) {
                        return false;
                    }
                    var filters = $this.closest('ul');
                    filters.find('.selected').removeClass('selected');
                    $this.addClass('selected');

                    var options = {
                            layoutMode: layoutMode,
                            transitionDuration: '0.4s',
                            packery: {
                                horizontal: true
                            },
                            masonry: masonry_options
                        },
                        key = filters.attr('data-option-key'),
                        value = $this.attr('data-option-value');
                    value = value === 'false' ? false : value;
                    options[key] = value;

                    $container.isotope(options);
                });
            });
        },
        directorLoadMore: function() {
            $('.director-shortcode-paging-wrapper .director-load-more').off().on('click', function(event) {
                event.preventDefault();

                var $this = $(this).button('loading');
                var link = $(this).attr('data-href');
                var shortcode_wrapper = '.director-shortcode-wrapper';
                var contentWrapper = '.director-shortcode-wrapper .director-list'; // parent element of .item
                var element = '.director-item'; // .item

                $.get(link, function(data) {
                    var next_href = $('.director-load-more', data).attr('data-href');
                    var $newElems = $(element, data).css({
                        opacity: 0
                    });

                    $(contentWrapper).append($newElems);
                    $newElems.imagesLoaded(function() {
                        $newElems.animate({
                            opacity: 1
                        });

                        $(contentWrapper).isotope('appended', $newElems);
                        setTimeout(function() {
                            $(contentWrapper).isotope('layout');
                        }, 400);

                        HaruCircle.director.init();
                    });


                    if (typeof(next_href) == 'undefined') {
                        $this.parent().remove();
                    } else {
                        $this.button('reset');
                        $this.attr('data-href', next_href);
                    }

                });
            });
        },
        directorInfiniteScroll: function() {
            var shortcode_wrapper = '.director-shortcode-wrapper';
            var contentWrapper = '.director-shortcode-wrapper .director-list'; // parent element of .item
            $('.director-list', shortcode_wrapper).infinitescroll({
                navSelector: "#infinite_scroll_button",
                nextSelector: "#infinite_scroll_button a",
                itemSelector: ".director-item", // .item
                loading: {
                    'selector': '#infinite_scroll_loading',
                    'img': haru_framework_theme_url + '/assets/images/ajax-loader.gif',
                    'msgText': 'Loading...',
                    'finishedMsg': ''
                }
            }, function(newElements, data, url) {
                var $newElems = $(newElements).css({
                    opacity: 0
                });
                $newElems.imagesLoaded(function() {
                    $newElems.animate({
                        opacity: 1
                    });

                    $(contentWrapper).isotope('appended', $newElems);
                    setTimeout(function() {
                        $(contentWrapper).isotope('layout');
                    }, 400);

                    HaruCircle.director.init();
                });

            });
        },
        singleDirectorGallery: function() {
            $('.haru-single-director .director-gallery').each(function(index, value) {
                var self = $(this);
                var $container = $(this).find('.director-images:not(.list)'); // parent element of .item
                var masonry_options = {
                    'gutter': 0
                };

                // Add to process products layout style
                var layoutMode = 'masonry';

                $container.isotope({
                    itemSelector: '.image-item', // .item
                    transitionDuration: '0.4s',
                    masonry: masonry_options,
                    layoutMode: layoutMode
                });

                imagesLoaded(self, function() {
                    $container.isotope('layout');
                });

                $(window).resize(function() {
                    $container.isotope('layout');
                });
            });
        }
    };

    // Film
    HaruCircle.film = {
        init: function() {
            HaruCircle.film.shortcodeFilm(); // Film Grid
            HaruCircle.film.filmLoadMore();
            HaruCircle.film.filmInfiniteScroll();
            HaruCircle.film.filmModal();
            HaruCircle.film.filmPlayerDirect();
        },
        shortcodeFilm: function() {
            var default_filter = [];
            var array_filter = []; // Push filter to an array to process when don't have filter

            $('.film-shortcode-wrapper:not(.slideshow)').each(function(index, value) {
                // Process filter each shortcode
                $(this).find('.film-filter li').first().find('a').addClass('selected');

                default_filter[index] = $(this).find('.film-filter li').first().find('a').attr('data-option-value');

                var self = $(this);
                var $container = $(this).find('.film-list'); // parent element of .item
                var $filter = $(this).find('.film-filter a');
                var masonry_options = {
                    'gutter': 0
                };

                array_filter[index] = $filter;

                // Add to process products layout style
                var layoutMode = 'fitRows';
                if (($(this).hasClass('masonry'))) {
                    var layoutMode = 'masonry';
                }

                for (var i = 0; i < array_filter.length; i++) {
                    if (array_filter[i].length == 0) {
                        default_filter = '';
                    }
                    $container.isotope({
                        itemSelector: '.film-item', // .item
                        transitionDuration: '0.4s',
                        masonry: masonry_options,
                        layoutMode: layoutMode,
                        filter: default_filter[i]
                    });
                }

                imagesLoaded(self, function() {
                    $container.isotope('layout');
                });

                $(window).resize(function() {
                    $container.isotope('layout');
                });

                $filter.click(function(e) {
                    e.stopPropagation();
                    e.preventDefault();

                    var $this = $(this);
                    // Don't proceed if already selected
                    if ($this.hasClass('selected')) {
                        return false;
                    }
                    var filters = $this.closest('ul');
                    filters.find('.selected').removeClass('selected');
                    $this.addClass('selected');

                    var options = {
                            layoutMode: layoutMode,
                            transitionDuration: '0.4s',
                            packery: {
                                horizontal: true
                            },
                            masonry: masonry_options
                        },
                        key = filters.attr('data-option-key'),
                        value = $this.attr('data-option-value');
                    value = value === 'false' ? false : value;
                    options[key] = value;

                    $container.isotope(options);
                });
            });
        },
        filmLoadMore: function() {
            $('.film-shortcode-paging-wrapper .film-load-more').off().on('click', function(event) {
                event.preventDefault();

                var $this = $(this).button('loading');
                var link = $(this).attr('data-href');
                var shortcode_wrapper = '.film-shortcode-wrapper';
                var contentWrapper = '.film-shortcode-wrapper .film-list'; // parent element of .item
                var element = '.film-item'; // .item

                $.get(link, function(data) {
                    var next_href = $('.film-load-more', data).attr('data-href');
                    var $newElems = $(element, data).css({
                        opacity: 0
                    });

                    $(contentWrapper).append($newElems);
                    $newElems.imagesLoaded(function() {
                        $newElems.animate({
                            opacity: 1
                        });

                        $(contentWrapper).isotope('appended', $newElems);
                        setTimeout(function() {
                            $(contentWrapper).isotope('layout');
                        }, 400);

                        HaruCircle.film.filmModal();
                    });


                    if (typeof(next_href) == 'undefined') {
                        $this.parent().remove();
                    } else {
                        $this.button('reset');
                        $this.attr('data-href', next_href);
                    }

                });
            });
        },
        filmInfiniteScroll: function() {
            var shortcode_wrapper = '.film-shortcode-wrapper';
            var contentWrapper = '.film-shortcode-wrapper .film-list'; // parent element of .item
            $('.film-list', shortcode_wrapper).infinitescroll({
                navSelector: "#infinite_scroll_button",
                nextSelector: "#infinite_scroll_button a",
                itemSelector: ".film-item", // .item
                loading: {
                    'selector': '#infinite_scroll_loading',
                    'img': haru_framework_theme_url + '/assets/images/ajax-loader.gif',
                    'msgText': 'Loading...',
                    'finishedMsg': ''
                }
            }, function(newElements, data, url) {
                var $newElems = $(newElements).css({
                    opacity: 0
                });
                $newElems.imagesLoaded(function() {
                    $newElems.animate({
                        opacity: 1
                    });

                    $(contentWrapper).isotope('appended', $newElems);
                    setTimeout(function() {
                        $(contentWrapper).isotope('layout');
                    }, 400);

                    HaruCircle.film.filmModal();
                });

            });
        },
        displayFilmServer: function(evt, cityName) {
            $('.video-playlist').find('.film-server-content').hide();
            $('.video-playlist').find('.film-server-content').first().show();
            $('.video-playlist').find('.video-episodes a').on('click', function(e) {
                e.preventDefault();

                // Episode active
                $('.video-playlist').find('.video-episodes a').removeClass('active');
                $('.video-playlist').find('.film-server-content').hide();

                $(this).addClass('active');
                var episode_servers = $(this).data('episode');
                $('.video-playlist').find('#' + episode_servers).show();
            });
        },
        displayPlayer: function(film_id, player_js, server) {
            // Do not use Player JS
            if( player_js == 'none' ) {
                setTimeout(function() {
                    // Youtube
                    if ( server == 'youtube' ) {
                        setTimeout(function() {
                            // Do something like autoplay
                        }, 300);
                    }
                    // Vimeo
                    else if ( server == 'vimeo' ) {
                        setTimeout(function() {
                            // Do something like autoplay
                        }, 300);
                    }
                    // Local
                    else {
                        var player;

                        if (!player) {
                            player = $('#film-player-' + film_id).mediaelementplayer({
                                stretching: 'responsive',
                                features: ['playpause', 'progress', 'current', 'duration', 'volume', 'fullscreen'],
                                // pluginPath: "/path/to/shims/",
                                // When using jQuery's `mediaelementplayer`, an `instance` argument
                                // is available in the `success` callback
                                success: function(mediaElement, originalNode, instance) {
                                    // Hidden play button
                                    // $self.css('display', 'none');
                                    // Do something
                                    mediaElement.load();
                                    setTimeout(function() {
                                        mediaElement.play();
                                    }, 300);
                                }
                            });
                        }
                    }
                    // Change video source
                    $('.film-server-content .video-server a').each(function() {
                        $(this).on('click', function(e) {
                            e.preventDefault();

                            var player_wrap = $(this).parents('.film-videos-wrapper').find('.player-wrapper');
                            var server = $(this).data('server').toString();
                            var video_id = $(this).data('video-id');
                            var mp4_url = $(this).data('mp4-url');
                            var webm_url = $(this).data('webm-url');
                            var film_id = $(this).data('film-id');

                            $.ajax({
                                type : "POST",
                                timeout : 30000,
                                url : haru_framework_ajax_url,
                                data : {
                                    action: 'haru_get_player_ajax', 
                                    server: server, 
                                    video_id: video_id, 
                                    mp4_url: mp4_url,
                                    webm_url: webm_url,
                                    film_id: film_id
                                },
                                error: function(xhr,err) {
                                    console.log('Have something wrong! Please try again!');
                                },
                                success: function(response) {
                                    if ( response ) {       
                                        player_wrap.find('.film-player').remove();
                                        player_wrap.append( response );

                                        // Element
                                        if ( server == 'url' ) {
                                            var player;

                                            if (!player) {
                                                player = $('#film-player-' + film_id).mediaelementplayer({
                                                    stretching: 'responsive',
                                                    features: ['playpause', 'progress', 'current', 'duration', 'volume', 'fullscreen'],
                                                    // pluginPath: "/path/to/shims/",
                                                    // When using jQuery's `mediaelementplayer`, an `instance` argument
                                                    // is available in the `success` callback
                                                    success: function(mediaElement, originalNode, instance) {
                                                        // Hidden play button
                                                        // $self.css('display', 'none');
                                                        // Do something
                                                        mediaElement.load();
                                                        setTimeout(function() {
                                                            mediaElement.play();
                                                        }, 300);
                                                    }
                                                });
                                            }
                                        }
                                    }
                                }
                            });

                        });
                    });
                }, 300);
            }
        },
        filmModal: function() {
            $('.view-film-button').off().on('click', function(e) {
                e.preventDefault();
                var film_id = $(this).data('id');
                var player_js = $(this).attr('data-player');
                var server = $(this).attr('data-server');

                $.ajax({
                    url: haru_framework_ajax_url,
                    type: "POST",
                    data: {
                        action: 'haru_film_modal',
                        film_id: film_id
                    },
                    dataType: "html",
                    beforeSend: function() {
                        HaruCircle.base.beforeAjax()
                    }
                }).done(function(result) {

                    HaruCircle.base.afterAjax();

                    $.magnificPopup.open({
                        type: "inline",
                        mainClass: 'mfp-zoom-in',
                        zoom: {
                            enabled: true, // By default it's false, so don't forget to enable it

                            duration: 300, // duration of the effect, in milliseconds
                            easing: 'ease-in-out', // CSS transition easing function

                            // The "opener" function should return the element from which popup will be zoomed in
                            // and to which popup will be scaled down
                            // By defailt it looks for an image tag:
                            opener: function(openerElement) {
                                // openerElement is the element on which popup was initialized, in this case its <a> tag
                                // you don't need to add "opener" option if this code matches your needs, it's defailt one.
                                return openerElement.is('img') ? openerElement : openerElement.find('img');
                            }
                        },
                        items: {
                            src: result
                        },
                        callbacks: {
                            open: function() {
                                HaruCircle.film.displayPlayer(film_id, player_js, server);
                                HaruCircle.film.displayFilmServer();
                            },
                            close: function() {
                                var videos = document.getElementsByTagName('video');
                                for( var i = 0, total = videos.length; i < total; i++ ){
                                    videos[i].parentNode.removeChild(videos[i]);
                                }
                                console.log(1);
                            }
                        }
                    });
                });
            });
        },
        filmPlayerDirect: function() {
            $('.haru_film .player-direct').hide();

            $('.film-player-direct').off().on('click', function(e) {
                e.preventDefault();

                var buttonClick = $(this);

                var film_id = $(this).data('id');
                var player_js = $(this).attr('data-player');
                var server = $(this).attr('data-server');

                $('.haru_film .player-direct').show();

                HaruCircle.film.displayPlayer(film_id, player_js, server);
                HaruCircle.film.displayFilmServer();
            });
        }
    };

    // Film Search
    HaruCircle.filmSearch = {
        init: function() {
            HaruCircle.filmSearch.shortcodeFilmSearchInit();
            HaruCircle.filmSearch.shortcodeFilmSearchLoadMore();
            HaruCircle.filmSearch.shortcodeFilmSearch();
            HaruCircle.filmSearch.shortcodeFilmSearchLoadMoreAjax();
        },
        shortcodeFilmSearchInit: function() {
            $('.film-search-form-shortcode-wrapper').each(function(index, value) {
                var self = $(this);
                var $container = $(this).find('.film-list'); // parent element of .item

                $container.isotope({
                    itemSelector: '.film-item', // .item
                    transitionDuration: '0.4s',
                    masonry: {
                        'gutter': 0
                    },
                    layoutMode: 'fitRows'
                });

                imagesLoaded(self, function() {
                    $container.isotope('layout');
                });
            });
        },
        shortcodeFilmSearchLoadMore: function() {
            $('.film-search-form-shortcode-paging-wrapper .film-load-more').off().on('click', function(event) {
                event.preventDefault();

                var $this = $(this).button('loading');
                var link = $(this).attr('data-href');
                var shortcode_wrapper = '.film-search-form-shortcode-wrapper';
                var contentWrapper = '.film-search-form-shortcode-wrapper .film-list'; // parent element of .item
                var element = '.film-item'; // .item

                $.get(link, function(data) {
                    var next_href = $('.film-load-more', data).attr('data-href');
                    var $newElems = $(element, data).css({
                        opacity: 0
                    });

                    $(contentWrapper).append($newElems);
                    $newElems.imagesLoaded(function() {
                        $newElems.animate({
                            opacity: 1
                        });

                        $(contentWrapper).isotope('appended', $newElems);
                        setTimeout(function() {
                            $(contentWrapper).isotope('layout');
                        }, 400);

                        HaruCircle.film.init();
                    });


                    if (typeof(next_href) == 'undefined') {
                        $this.parent().remove();
                    } else {
                        $this.button('reset');
                        $this.attr('data-href', next_href);
                    }

                });
            });
        },
        shortcodeFilmSearch: function() {
            $('.film-search-form-shortcode-wrapper .film-searchform .search-film').off().on('click', function(event) {
                event.preventDefault();

                var form = $('.film-search-form-shortcode-wrapper .film-searchform');
                var input = form.find('input[name="s"]').val();
                var category = form.find("#category").val();
                var country = form.find("#country").val();
                var year = form.find("#year").val();
                var sort = form.find("#sort").val();

                var columns = form.find('.data-search').attr("data-columns");
                var film_style = form.find('.data-search').attr("data-film_style");
                var paging_style = form.find('.data-search').attr("data-paging_style");
                var per_page = form.find('.data-search').attr("data-per_page");
                var current_page = form.find('.data-search').attr("data-current_page");

                var contentWrapper = '.film-search-form-shortcode-wrapper .film-content';

                $.ajax({
                    url: haru_framework_ajax_url,
                    type: "POST",
                    data: {
                        action: 'haru_film_shortcode_ajax_search',
                        input: input,
                        category: category,
                        country: country,
                        year: year,
                        sort: sort,
                        columns,
                        film_style,
                        paging_style,
                        per_page,
                        current_page,
                        offset: (current_page * per_page) // doesn't need + 1
                    },
                    dataType: "html",
                    beforeSend: function() {
                        $(contentWrapper).addClass('loading');
                        form.find('#searchsubmit').prop('disabled', true); // Disable button doesn't work now
                    }
                }).done(function(result) {
                    $(contentWrapper).empty();
                    $(contentWrapper).append(result);
                    $(result).imagesLoaded(function() {
                        HaruCircle.filmSearch.init();
                        HaruCircle.film.filmModal();
                        $(contentWrapper).removeClass('loading');
                        form.find('#searchsubmit').prop('disabled', false);
                    });
                });

            });
        },
        shortcodeFilmSearchLoadMoreAjax: function() {
            var current_page = 1;

            $('.film-search-form-shortcode-paging-wrapper .film-load-more-ajax').off().on('click', function(event) {
                event.preventDefault();

                var $this = $(this).button('loading');
                var shortcode_wrapper = '.film-search-form-shortcode-wrapper';
                var contentWrapper = '.film-search-form-shortcode-wrapper .film-list'; // parent element of .item
                var element = '.film-item'; // .item

                // Button Load More value
                var input = $(this).attr('data-input');
                var category = $(this).attr("data-category");
                var country = $(this).attr("data-country");
                var year = $(this).attr("data-year");
                var sort = $(this).attr("data-sort");

                var columns = $(this).attr("data-columns");
                var film_style = $(this).attr("data-film_style");
                var paging_style = $(this).attr("data-paging_style");
                var per_page = $(this).attr("data-per_page");

                $.ajax({
                    url: haru_framework_ajax_url,
                    type: "POST",
                    data: {
                        action: 'haru_film_shortcode_ajax_search_loadmore',
                        input: input,
                        category: category,
                        country: country,
                        year: year,
                        sort: sort,
                        columns,
                        film_style,
                        paging_style,
                        per_page,
                        offset: (current_page * per_page) // doesn't need + 1
                    },
                    dataType: "html",
                    beforeSend: function() {

                    }
                }).done(function(result) {
                    current_page++;

                    var $newElems = $(element, result).css({
                        opacity: 0
                    });

                    $(contentWrapper).append($newElems);
                    $newElems.imagesLoaded(function() {
                        $newElems.animate({
                            opacity: 1
                        });

                        $(contentWrapper).isotope('appended', $newElems);
                        setTimeout(function() {
                            $(contentWrapper).isotope('layout');
                        }, 400);

                        HaruCircle.film.init();
                    });

                    // Check if no more item
                    var $noMoreElem = $('.no-more-item', result);
                    if ($noMoreElem.hasClass('no-more-item')) {
                        $this.parent().remove();
                    } else {
                        $this.button('reset');
                    }
                });
            });
        }
    };

    // Trailer
    HaruCircle.trailer = {
        init: function() {
            HaruCircle.trailer.shortcodeTrailer(); // Trailer Grid
            HaruCircle.trailer.trailerModal();
        },
        shortcodeTrailer: function() {
            $('.trailer-shortcode-wrapper').each(function() {
                var $this = $(this);

                if ($this.hasClass('carousel')) {
                    $this.find('.slider-for').slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: true,
                        fade: false,
                        asNavFor: $('.slider-nav', $this)
                    });
                    $this.find('.slider-nav').slick({
                        slidesToShow: 5,
                        slidesToScroll: 1,
                        arrows: true,
                        asNavFor: $('.slider-for', $this),
                        dots: false,
                        centerMode: false,
                        centerPadding: '0px',
                        focusOnSelect: true,
                        responsive: [{
                                breakpoint: 991,
                                settings: {
                                    slidesToShow: 3
                                }
                            },
                            {
                                breakpoint: 767,
                                settings: {
                                    slidesToShow: 3
                                }
                            }
                        ]
                    });
                }
                // Carousel 2, 3
                if ($this.hasClass('carousel_2') || $this.hasClass('carousel_3')) {
                    $this.find('.slider-for').slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: true,
                        fade: false
                    });
                }
            });
        },
        trailerModal: function() {
            $('.view-trailer-button').off().on('click', function(e) {
                e.preventDefault();
                var trailer_id = $(this).data('id');
                var player_js = $(this).attr('data-player');
                var server = $(this).attr('data-server');

                $.ajax({
                    url: haru_framework_ajax_url,
                    type: "POST",
                    data: {
                        action: 'haru_trailer_modal',
                        trailer_id: trailer_id
                    },
                    dataType: "html",
                    beforeSend: function() {
                        HaruCircle.base.beforeAjax()
                    }
                }).done(function(result) {
                    HaruCircle.base.afterAjax();

                    $.magnificPopup.open({
                        type: "inline",
                        mainClass: 'mfp-zoom-in',
                        zoom: {
                            enabled: true, // By default it's false, so don't forget to enable it
                            duration: 300, // duration of the effect, in milliseconds
                            easing: 'ease-in-out', // CSS transition easing function
                            // The "opener" function should return the element from which popup will be zoomed in
                            // and to which popup will be scaled down
                            // By defailt it looks for an image tag:
                            opener: function(openerElement) {
                                // openerElement is the element on which popup was initialized, in this case its <a> tag
                                // you don't need to add "opener" option if this code matches your needs, it's defailt one.
                                return openerElement.is('img') ? openerElement : openerElement.find('img');
                            }
                        },
                        items: {
                            src: result
                        },
                        callbacks: {
                            open: function() {
                                HaruCircle.trailer.displayTrailerPlayer(trailer_id, player_js, server);
                            }
                        }
                    });
                });
            });
        },
        displayTrailerPlayer: function(trailer_id, player_js, server) {
            // Do not use Player JS
            if( player_js == 'none' ) {
                setTimeout(function() {
                    // Youtube
                    if ( server == 'youtube' ) {
                        setTimeout(function() {
                            // Do something like autoplay
                        }, 300);
                    }
                    // Vimeo
                    if ( server == 'vimeo' ) {
                        setTimeout(function() {
                            // Do something like autoplay
                        }, 300);
                    }
                    // Local
                    if ( server == 'url' ) {
                        var player;

                        if (!player) {
                            player = $('#trailer-player').mediaelementplayer({
                                stretching: 'responsive',
                                features: ['playpause', 'progress', 'current', 'duration', 'volume', 'fullscreen'],
                                // pluginPath: "/path/to/shims/",
                                // When using jQuery's `mediaelementplayer`, an `instance` argument
                                // is available in the `success` callback
                                success: function(mediaElement, originalNode, instance) {
                                    // Hidden play button
                                    // $self.css('display', 'none');
                                    // Do something
                                    mediaElement.load();
                                    setTimeout(function() {
                                        mediaElement.play();
                                    }, 300);
                                }
                            });
                        }
                    }
                }, 300);
            }
            // 
        },
    };

    // Blog
    HaruCircle.blog = {
        init: function() {
            HaruCircle.blog.shortcodeBlog(); // Blog Grid
            HaruCircle.blog.blogLoadMore();
            HaruCircle.blog.blogInfiniteScroll();
        },
        shortcodeBlog: function() {
            $('.blog-shortcode-wrapper').each(function(index, value) {
                var self = $(this);
                var $container = $(this).find('.blog-list'); // parent element of .item
                var masonry_options = {
                    'gutter': 0
                };

                // Add to process products layout style
                var layoutMode = 'packery';

                $container.isotope({
                    itemSelector: '.blog-item', // .item
                    transitionDuration: '0.4s',
                    masonry: masonry_options,
                    layoutMode: layoutMode
                });

                imagesLoaded(self, function() {
                    $container.isotope('layout');
                });

                $(window).resize(function() {
                    $container.isotope('layout');
                });
            });
        },
        blogLoadMore: function() {
            $('.blog-shortcode-paging .blog-load-more').off().on('click', function(event) {
                event.preventDefault();

                var $this = $(this).button('loading');
                var link = $(this).attr('data-href');
                var shortcode_wrapper = '.blog-shortcode-wrapper';
                var contentWrapper = '.blog-shortcode-wrapper .blog-list'; // parent element of .item
                var element = '.blog-item:not(.featured-post)'; // .item

                $.get(link, function(data) {
                    var next_href = $('.blog-load-more', data).attr('data-href');
                    var $newElems = $(element, data).css({
                        opacity: 0
                    });

                    $(contentWrapper).append($newElems);
                    $newElems.imagesLoaded(function() {
                        $newElems.animate({
                            opacity: 1
                        });

                        $(contentWrapper).isotope('appended', $newElems);
                    });


                    if (typeof(next_href) == 'undefined') {
                        $this.parent().remove();
                    } else {
                        $this.button('reset');
                        $this.attr('data-href', next_href);
                    }

                });
            });
        },
        blogInfiniteScroll: function() {
            var shortcode_wrapper = '.blog-shortcode-wrapper';
            var contentWrapper = '.blog-shortcode-wrapper .blog-list'; // parent element of .item
            $('.blog-list', shortcode_wrapper).infinitescroll({
                navSelector: "#infinite_scroll_button",
                nextSelector: "#infinite_scroll_button a",
                itemSelector: ".blog-item:not(.featured-post)", // .item
                loading: {
                    'selector': '#infinite_scroll_loading',
                    'img': haru_framework_theme_url + '/assets/images/ajax-loader.gif',
                    'msgText': 'Loading...',
                    'finishedMsg': ''
                }
            }, function(newElements, data, url) {
                var $newElems = $(newElements).css({
                    opacity: 0
                });
                $newElems.imagesLoaded(function() {
                    $newElems.animate({
                        opacity: 1
                    });

                    $(contentWrapper).isotope('appended', $newElems);
                });

            });
        }
    };

    $(document).ready(function() {
        HaruCircle.init();
    });
})(jQuery);