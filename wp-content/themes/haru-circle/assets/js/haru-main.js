/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
 */
var HARU = HARU || {};
(function($) {
    "use strict";

    var $window = $(window),
        deviceAgent = navigator.userAgent.toLowerCase(),
        isMobile = deviceAgent.match(/(iphone|ipod|android|iemobile)/),
        isMobileAlt = deviceAgent.match(/(iphone|ipod|ipad|android|iemobile)/),
        $body = $('body');

    // Base functions
    HARU.base = {
        init: function() {
            HARU.base.prettyPhoto();
            HARU.base.stellar();
            HARU.base.popup();
        },
        owlCarousel: function() { // @TODO
            $('div.owl-carousel:not(.manual)').each(function() {
                var slider = $(this);

                var defaults = {
                    // Most important owl features
                    items: 4,
                    margin: 0,
                    loop: true,
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
                    navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
                    rewind: true,
                    navElement: 'div',
                    slideBy: 1,
                    dots: true,
                    dotsEach: false,
                    lazyLoad: false,
                    lazyContent: false,

                    autoplay: false,
                    autoplayTimeout: 2000,
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
                            items: 2
                        },
                        991: {
                            items: 4
                        },
                        1200: {
                            items: 4
                        },
                        1300: {
                            items: 4
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
                };

                var columns = slider.data("carousel-options");
                var config = {
                    item: columns,
                    pagination: false,
                    navigation: true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        500: {
                            items: 2
                        },
                        991: {
                            items: columns
                        },
                        1200: {
                            items: columns
                        },
                        1300: {
                            items: columns
                        }
                    },

                }
                var configs = $.extend(defaults, config);
                var fucStr_afterInit = config.afterInit;
                // Initialize Slider
                slider.owlCarousel(configs);
            });
        },
        prettyPhoto: function() {
            $("a[data-rel^='prettyPhoto']").prettyPhoto({
                hook: 'data-rel',
                social_tools: '',
                animation_speed: 'normal',
                theme: 'light_square'
            });
        },
        stellar: function() {
            $.stellar({
                horizontalScrolling: false,
                scrollProperty: 'scroll',
                positionProperty: 'position'
            });
        },
        popup: function() {
            // Reference: http://stackoverflow.com/questions/1458724/how-to-set-unset-cookie-with-jquery
            var et_popup_closed = $.cookie('haru_popup_closed');
            var popup_effect = $('.haru-popup').data('effect');
            var popup_delay = $('.haru-popup').data('delay');

            setTimeout(function() {
                $('.haru-popup').magnificPopup({
                    items: {
                        src: '#haru-popup',
                        type: 'inline'
                    },
                    removalDelay: 500, //delay removal by X to allow out-animation
                    callbacks: {
                        beforeOpen: function() {
                            this.st.mainClass = popup_effect;
                        },
                        beforeClose: function() {
                            if ($('#showagain:checked').val() == 'do-not-show')
                                $.cookie('haru_popup_closed', 'do-not-show', {
                                    expires: 1,
                                    path: '/'
                                });
                        },
                    }
                    // (optionally) other options
                });

                if (et_popup_closed != 'do-not-show' && $('.haru-popup').length > 0 && $('body').hasClass('open-popup')) {
                    $('.haru-popup').magnificPopup('open');
                }
            }, popup_delay);
        }
    }

    // Common
    HARU.common = {
        init: function() {
            HARU.common.magicLine();
        },
        isDesktop: function() {
            var responsive_breakpoint = 991;

            return window.matchMedia('(min-width: ' + (responsive_breakpoint + 1) + 'px)').matches;
        },
        magicLine: function() {
            $('.magic-line-container').each(function() {
                var activeItem = $('li.active', this);
                HARU.common.magicLineSetPosition(activeItem);
                $('li', this).hover(function() {
                    if (!$(this).hasClass('none-magic-line')) {
                        HARU.common.magicLineSetPosition(this);
                    }

                }, function() {
                    if (!$(this).hasClass('none-magic-line')) {
                        HARU.common.magicLineReturnActive(this);
                    }
                });
            });
        },
    };

    // Blog functions
    HARU.blog = {
        init: function() {
            HARU.blog.owlCarousel();
            HARU.blog.jPlayerSetup();
            HARU.blog.loadMore();
            HARU.blog.infiniteScroll();
            HARU.blog.gridLayout();
            HARU.blog.masonryLayout();
        },
        windowResized: function() {
            HARU.blog.processWidthAudioPlayer();
        },
        owlCarousel: function() {
            $('div.owl-carousel.post-gallery').each(function() {
                $(this).owlCarousel({
                    items: 1,
                    margin: 0,
                    loop: false,
                    mouseDrag: true,
                    touchDrag: true,
                    nav: true,
                    navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
                    responsive: {
                        0: {
                            items: 1
                        },
                        500: {
                            items: 1
                        },
                        991: {
                            items: 1
                        },
                        1200: {
                            items: 1
                        },
                        1300: {
                            items: 1
                        }
                    },
                });
            });
        },
        jPlayerSetup: function() {
            $('.jp-jplayer').each(function() {
                var $this = $(this),
                    url = $this.data('audio'),
                    title = $this.data('title'),
                    type = url.substr(url.lastIndexOf('.') + 1),
                    player = '#' + $this.data('player'),
                    audio = {};
                audio[type] = url;
                audio['title'] = title;
                $this.jPlayer({
                    ready: function() {
                        $this.jPlayer('setMedia', audio);
                    },
                    swfPath: '../libraries/jPlayer',
                    cssSelectorAncestor: player
                });
            });
            HARU.blog.processWidthAudioPlayer();
        },
        processWidthAudioPlayer: function() {
            setTimeout(function() {
                $('.jp-audio .jp-type-playlist').each(function() {
                    var _width = $(this).outerWidth() - $('.jp-play-pause', this).outerWidth() - parseInt($('.jp-play-pause', this).css('margin-left').replace('px', ''), 10) - parseInt($('.jp-progress', this).css('margin-left').replace('px', ''), 10) - $('.jp-volume', this).outerWidth() - parseInt($('.jp-volume', this).css('margin-left').replace('px', ''), 10) - 15;
                    $('.jp-progress', this).width(_width);
                });
            }, 100);
        },
        loadMore: function() {
            $('.blog-load-more').on('click', function(event) {
                event.preventDefault();
                var $this = $(this).button('loading');
                var link = $(this).attr('data-href');
                var contentWrapper = '.archive-content-layout .row';
                var element = 'article';

                $.get(link, function(data) {
                    var next_href = $('.blog-load-more', data).attr('data-href');
                    var $newElems = $(element, data).css({
                        opacity: 0
                    });

                    $(contentWrapper).append($newElems);
                    $newElems.imagesLoaded(function() {
                        HARU.blog.owlCarousel();
                        HARU.blog.jPlayerSetup();
                        HARU.base.prettyPhoto();
                        $newElems.animate({
                            opacity: 1
                        });

                        // Process masonry/grid blog layout
                        if (($(contentWrapper).parent().hasClass('layout-style-masonry')) || ($(contentWrapper).parent().hasClass('layout-style-grid'))) {
                            $(contentWrapper).isotope('appended', $newElems);
                            setTimeout(function() {
                                $(contentWrapper).isotope('layout');
                            }, 400);
                        }

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
        infiniteScroll: function() {
            var contentWrapper = '.archive-content-layout .row';
            $(contentWrapper).infinitescroll({
                navSelector: "#infinite_scroll_button",
                nextSelector: "#infinite_scroll_button a",
                itemSelector: "article",
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
                    HARU.blog.owlCarousel();
                    HARU.blog.jPlayerSetup();
                    HARU.base.prettyPhoto();
                    $newElems.animate({
                        opacity: 1
                    });

                    // Process masonry/grid blog layout
                    if (($(contentWrapper).parent().hasClass('layout-style-masonry')) || ($(contentWrapper).parent().hasClass('layout-style-grid'))) {
                        $(contentWrapper).isotope('appended', $newElems);
                        setTimeout(function() {
                            $(contentWrapper).isotope('layout');
                        }, 400);
                    }
                });
            });
        },
        gridLayout: function() {
            var $blog_grid = $('.layout-style-grid .row');
            $blog_grid.imagesLoaded(function() {
                $blog_grid.isotope({
                    itemSelector: 'article',
                    layoutMode: "fitRows"
                });
                setTimeout(function() {
                    $blog_grid.isotope('layout');
                }, 500);
            });
        },
        masonryLayout: function() {
            var $blog_masonry = $('.layout-style-masonry .row');
            $blog_masonry.imagesLoaded(function() {
                $blog_masonry.isotope({
                    itemSelector: 'article',
                    layoutMode: "masonry"
                });

                setTimeout(function() {
                    $blog_masonry.isotope('layout');
                }, 500);
            });
        }
    }

    // Page functions
    HARU.page = {
        init: function() {
            HARU.page.backToTop();
            HARU.page.overlayVisualComposer();
        },
        windowLoad: function() {
            if ($body.hasClass('haru-site-preloader')) {
                HARU.page.pageIn();
            }
        },
        pageIn: function() {
            setTimeout(function() {
                $('#haru-site-preloader').fadeOut(300);
            }, 300);
        },
        backToTop: function() {
            var $backToTop = $('.back-to-top');
            if ($backToTop.length > 0) {
                $backToTop.click(function(event) {
                    event.preventDefault();
                    $('html,body').animate({
                        scrollTop: '0px'
                    }, 800);
                });
                $window.on('scroll', function(event) {
                    var scrollPosition = $window.scrollTop();
                    var windowHeight = $window.height() / 2;
                    if (scrollPosition > windowHeight) {
                        $backToTop.addClass('in');
                    } else {
                        $backToTop.removeClass('in');
                    }
                });
            }
        },
        overlayVisualComposer: function() {
            $('[data-overlay-color]').each(function() {
                var $selector = $(this);
                setTimeout(function() {
                    var overlay_color = $selector.data('overlay-color');
                    var html = '<div class="overlay-bg-vc" style="background-color: ' + overlay_color + '"></div>';
                    $selector.prepend(html);
                }, 100);
            });
        },
    }

    // Search popup select up or down
    HARU.search = {
        up: function($wrapper) {
            var $item = $('li.selected', $wrapper);
            if ($('li', $wrapper).length < 2) return;
            var $prev = $item.prev();
            $item.removeClass('selected');
            if ($prev.length) {
                $prev.addClass('selected');
            } else {
                $('li:last', $wrapper).addClass('selected');
                $prev = $('li:last', $wrapper);
            }
            var $ajaxSearchResult = $(' > ul', $wrapper);

            if ($prev.position().top < $ajaxSearchResult.scrollTop()) {
                $ajaxSearchResult.scrollTop($prev.position().top);
            } else if ($prev.position().top + $prev.outerHeight() > $ajaxSearchResult.scrollTop() + $ajaxSearchResult.height()) {
                $ajaxSearchResult.scrollTop($prev.position().top - $ajaxSearchResult.height() + $prev.outerHeight());
            }
        },
        down: function($wrapper) {
            var $item = $('li.selected', $wrapper);
            if ($('li', $wrapper).length < 2) return;
            var $next = $item.next();
            $item.removeClass('selected');
            if ($next.length) {
                $next.addClass('selected');
            } else {
                $('li:first', $wrapper).addClass('selected');
                $next = $('li:first', $wrapper);
            }
            var $ajaxSearchResult = $('> ul', $wrapper);

            if ($next.position().top < $ajaxSearchResult.scrollTop()) {
                $ajaxSearchResult.scrollTop($next.position().top);
            } else if ($next.position().top + $next.outerHeight() > $ajaxSearchResult.scrollTop() + $ajaxSearchResult.height()) {
                $ajaxSearchResult.scrollTop($next.position().top - $ajaxSearchResult.height() + $next.outerHeight());
            }
        }
    };

    // Header functions
    HARU.header = {
        timeOutSearch: null,
        init: function() {
            HARU.header.stickyHeader();
            HARU.header.menuMobile();
            HARU.header.canvasMenu(); // Canvas menu
            HARU.header.search(); // Search button popup
            HARU.header.searchAjaxForm(); // Search box ajax
            HARU.header.searchCategory(); // Search shop with category
        },
        windowResized: function() {
            HARU.header.stickyHeader();
            if (HARU.common.isDesktop()) {
                $('.toggle-icon-wrapper[data-drop]').removeClass('in');
            }
            var $adminBar = $('#wpadminbar');

            if ($adminBar.length > 0) {
                $body.attr('data-offset', $adminBar.outerHeight() + 1);
            }
            if ($adminBar.length > 0) {
                $body.attr('data-offset', $adminBar.outerHeight() + 1);
            }
            HARU.header.headerMobileFlyPosition();
            HARU.header.headerMobilePosition();
        },
        windowLoad: function() {
            HARU.header.headerMobileFlyPosition();
            HARU.header.headerMobilePosition();
        },
        stickyHeader: function() {
            var topSpacing = 0,
                $adminBar = $('#wpadminbar');

            if (($adminBar.length > 0) && ($adminBar.css('position') == 'fixed')) {
                topSpacing = $adminBar.outerHeight();
            }

            $('.header-sticky, .header-mobile-sticky').unstick();
            var topSticky = topSpacing;
            if (HARU.common.isDesktop()) {
                topSpacing = -$(window).height() + 60;
                $('.header-sticky').sticky({
                    topSpacing: topSpacing,
                    topSticky: topSticky
                });
            } else {
                $('.header-mobile-sticky').sticky({
                    topSpacing: topSpacing,
                    topSticky: topSticky
                });
            }
        },
        changeStickyWrapperSize: function(count) {
            var $sticky_wrapper = $('header.haru-main-header .haru-sticky-wrapper');
            if ($sticky_wrapper.length > 0) {
                $sticky_wrapper.height($(' > .header-sticky', $sticky_wrapper).outerHeight());
            }

            if (count > 0) {
                setTimeout(function() {
                    HARU.header.changeStickyWrapperSize(count - 1);
                }, 100);
            }
        },
        menuMobile: function() {
            $('.toggle-mobile-menu[data-ref]').click(function(event) {
                event.preventDefault();

                var $this = $(this);
                var data_drop = $this.data('ref');
                $this.toggleClass('in');
                switch ($this.data('drop-type')) {
                    case 'dropdown':
                        $('#' + data_drop).slideToggle();
                        break;
                    case 'fly':
                        $('body').toggleClass('menu-mobile-in');
                        $('#' + data_drop).toggleClass('in');
                        break;
                }
            });

            $('.toggle-icon-wrapper[data-ref]:not(.toggle-mobile-menu)').click(function(event) {
                event.preventDefault();

                var $this = $(this);
                var data_ref = $this.data('ref');
                $this.toggleClass('in');
                $('#' + data_ref).toggleClass('in');
            });

            $('.haru-mobile-menu-overlay').click(function() {
                $body.removeClass('menu-mobile-in');
                $('#haru-nav-mobile-menu').removeClass('in');
                $('.toggle-icon-wrapper[data-ref]').removeClass('in');
            });
        },
        headerMobileFlyPosition: function() {
            var top = 0;

            if (($('#wpadminbar').length > 0) && ($('#wpadminbar').css('position') == 'fixed')) {
                top = $('#wpadminbar').outerHeight();
            }
            if (top > 0) {
                $('.haru-mobile-header-nav.menu-drop-fly').css('top', top + 'px');
            } else {
                $('.haru-mobile-header-nav.menu-drop-fly').css('top', '');
            }
        },
        headerMobilePosition: function() {
            var top = 0;
            if (($('#wpadminbar').length > 0) && ($('#wpadminbar').css('position') == 'fixed')) {
                top = $('#wpadminbar').outerHeight();
            }
            if (top > 0) {
                $('.haru-mobile-header-nav.menu-drop-fly').css('top', top + 'px');
            } else {
                $('.haru-mobile-header-nav.menu-drop-fly').css('top', '');
            }
        },
        canvasMenu: function() {
            $(document).on('click', function(event) {
                if (($(event.target).closest('.haru-canvas-menu-wrapper').length == 0) &&
                    ($(event.target).closest('.canvas-menu-toggle')).length == 0) {
                    $('.haru-canvas-menu-wrapper').removeClass('in');
                }
            });

            $('.canvas-menu-toggle').on('click', function(event) {
                event.preventDefault();
                $('.haru-canvas-menu-wrapper').toggleClass('in');
            });
            $('.haru-canvas-menu-close').on('click', function(event) {
                event.preventDefault();
                $('.haru-canvas-menu-wrapper').removeClass('in');
            });
        },
        search: function() {
            $('header .icon-search-menu').click(function(event) {
                event.preventDefault();

                HARU.header.searchPopupOpen();
            });

            $('.haru-dismiss-modal, .modal-backdrop', '#haru-modal-search').click(function() {
                HARU.header.searchPopupClose();
            });


            // Search Ajax: 
            if ($(this).data('search-type') == 'ajax') {
                $('.haru-search-wrapper button > i.ajax-search-icon').click(function() {
                    s_search();
                });

                $('#search-ajax', '#haru-modal-search').on('keyup', function(event) {
                    if (event.altKey || event.ctrlKey || event.shiftKey || event.metaKey) {
                        return;
                    }

                    var keys = ["Control", "Alt", "Shift"];
                    if (keys.indexOf(event.key) != -1) return;
                    switch (event.which) {
                        case 27: // ESC
                            HARU.header.searchPopupClose();
                            break;
                        case 38: // UP
                            s_up();
                            break;
                        case 40: // DOWN
                            s_down();
                            break;
                        case 13: //ENTER
                            var $item = $('li.selected a', '#haru-modal-search');
                            if ($item.length == 0) {
                                event.preventDefault();
                                return false;
                            }
                            s_enter();
                            break;
                        default:
                            clearTimeout(HARU.header.timeOutSearch);
                            HARU.header.timeOutSearch = setTimeout(s_search, 500);
                            break;
                    }
                });
            }

            function s_up() {
                var $item = $('li.selected', '#haru-modal-search');

                if ($('li', '#haru-modal-search').length < 2) return;
                var $prev = $item.prev();
                $item.removeClass('selected');
                if ($prev.length) {
                    $prev.addClass('selected');
                } else {
                    $('li:last', '#haru-modal-search').addClass('selected');
                    $prev = $('li:last', '#haru-modal-search');
                }
                if ($prev.position().top < $('#haru-modal-search .ajax-search-result').scrollTop()) {
                    $('#haru-modal-search .ajax-search-result').scrollTop($prev.position().top);
                } else if ($prev.position().top + $prev.outerHeight() > $('#haru-modal-search .ajax-search-result').scrollTop() + $('#haru-modal-search .ajax-search-result').height()) {
                    $('#haru-modal-search .ajax-search-result').scrollTop($prev.position().top - $('#haru-modal-search .ajax-search-result').height() + $prev.outerHeight());
                }
            }

            function s_down() {
                var $item = $('li.selected', '#haru-modal-search');

                if ($('li', '#haru-modal-search').length < 2) return;
                var $next = $item.next();
                $item.removeClass('selected');
                if ($next.length) {
                    $next.addClass('selected');
                } else {
                    $('li:first', '#haru-modal-search').addClass('selected');
                    $next = $('li:first', '#haru-modal-search');
                }
                if ($next.position().top < $('#haru-modal-search .ajax-search-result').scrollTop()) {
                    $('#haru-modal-search .ajax-search-result').scrollTop($next.position().top);
                } else if ($next.position().top + $next.outerHeight() > $('#haru-modal-search .ajax-search-result').scrollTop() + $('#haru-modal-search .ajax-search-result').height()) {
                    $('#haru-modal-search .ajax-search-result').scrollTop($next.position().top - $('#haru-modal-search .ajax-search-result').height() + $next.outerHeight());
                }
            }

            function s_enter() {
                var $item = $('li.selected a', '#haru-modal-search');

                if ($item.length > 0) {
                    window.location = $item.attr('href');
                }
            }

            function s_search() {
                var keyword = $('input[type="search"]', '#haru-modal-search').val();

                if (keyword.length < 3) {
                    $('.ajax-search-result', '#haru-modal-search').html('');
                    return;
                }
                $('.ajax-search-icon', '#haru-modal-search').addClass('fa fa-spinner fa-spin');
                $('.ajax-search-icon', '#haru-modal-search').removeClass('ion-ios-search');
                $.ajax({
                    type: 'POST',
                    data: 'action=popup_search_result&keyword=' + keyword,
                    url: haru_framework_ajax_url,
                    success: function(data) {
                        $('.ajax-search-icon', '#haru-modal-search').removeClass('fa fa-spinner fa-spin');
                        $('.ajax-search-icon', '#haru-modal-search').addClass('ion-ios-search');
                        var html = '';
                        var html_view_more = '';
                        if (data) {
                            var items = $.parseJSON(data);
                            if (items.length) {
                                html += '<ul>';
                                if (items[0]['id'] == -1) {
                                    html += '<li>' + items[0]['title'] + '</li>';
                                } else {
                                    $.each(items, function(index) {
                                        if (this['id'] == -2) {
                                            html_view_more = '<div class="search-view-more">' + this['title'] + '</div>';
                                        } else {
                                            if (index == 0) {
                                                html += '<li class="selected">';
                                            } else {
                                                html += '<li>';
                                            }
                                            if (this['title'] == null || this['title'] == '') {
                                                html += '<a href="' + this['guid'] + '">' + this['date'] + '</a>';
                                            } else {
                                                html += '<a href="' + this['guid'] + '">' + this['title'] + '</a>';
                                                html += '<span>' + this['date'] + ' </span>';
                                            }
                                            html += '</li>';
                                        }
                                    });
                                }

                                html += '</ul>';
                            } else {
                                html = '';
                            }
                        }
                        $('.ajax-search-result', '#haru-modal-search').html(html + html_view_more);
                        $('#haru-modal-search .ajax-search-result').scrollTop(0);
                    },
                    error: function(data) {
                        $('.ajax-search-icon', '#haru-modal-search').removeClass('fa-spinner fa-spin');
                        $('.ajax-search-icon', '#haru-modal-search').addClass('fa-search');
                    }
                });
            }
        },
        searchPopupOpen: function() {
            if (!$('#haru-modal-search').hasClass('in')) {
                $('body').addClass('overflow-hidden');
                $('#haru-modal-search').show();
                setTimeout(function() {
                    $('#haru-modal-search').addClass('in');
                }, 300);

                if ($('#search-ajax', '#haru-modal-search').length > 0) {
                    $('#search-ajax', '#haru-modal-search').focus();
                    $('#search-ajax', '#haru-modal-search').val('');
                } else {
                    $('#search-standard', '#haru-modal-search').focus();
                    $('#search-standard', '#haru-modal-search').val('');
                }

                $('.ajax-search-result', '#haru-modal-search').html('');
            }
        },
        searchPopupClose: function() {
            if ($('#haru-modal-search').hasClass('in')) {
                $('#haru-modal-search').removeClass('in');
                setTimeout(function() {
                    $('#haru-modal-search').hide();
                    $('body').removeClass('overflow-hidden');
                }, 300);
            }
        },
        searchAjaxForm: function() {
            var $wrapper = $('header.haru-main-header .search-box-wrapper');
            var $form_wrapper = $('header.haru-main-header .search-box-wrapper form.search-type-ajax');

            $($window).click(function(event) {
                if ($(event.target).closest('header.haru-main-header .search-box-wrapper').length == 0) {
                    $('.ajax-search-result', $wrapper).remove();
                    $('> input[type="text"]', $form_wrapper).val('');
                }
            });

            $form_wrapper.submit(function() {
                return false;
            });

            $('> input[type="text"]', $form_wrapper).on('keyup', function(event) {
                if (event.altKey || event.ctrlKey || event.shiftKey || event.metaKey) {
                    return;
                }

                var keys = ["Control", "Alt", "Shift"];
                if (keys.indexOf(event.key) != -1) return;
                switch (event.which) {
                    case 27: // ESC
                        remove_search_result();
                        break;
                    case 38: // UP
                        HARU.search.up($wrapper);
                        break;
                    case 40: // DOWN
                        HARU.search.down($wrapper);

                        break;
                    case 13: //ENTER
                        s_enter();
                        break;
                    default:
                        clearTimeout(HARU.header.timeOutSearch);
                        HARU.header.timeOutSearch = setTimeout(s_search, 500);
                        break;
                }

                function remove_search_result() {
                    $('.ajax-search-result', $wrapper).remove();
                    $('> input[type="text"]', $form_wrapper).val('');
                }

                function s_enter() {
                    var $item = $('li.selected a', $wrapper);

                    if ($item.length > 0) {
                        window.location = $item.attr('href');
                    }
                }

                function s_search() {
                    var keyword = $('input[type="text"]', $form_wrapper).val();
                    if (keyword.length < 3) {
                        if ($('.ajax-search-result', $form_wrapper).length == 0) {
                            $($form_wrapper).append('<div class="ajax-search-result"></div>');
                        }
                        var hint_message = $wrapper.attr('data-hint-message');

                        $('.ajax-search-result', $wrapper).html('<ul><li class="no-result">' + hint_message + '</li></ul>');
                        return;
                    }
                    $('button > i', $form_wrapper).addClass('fa-spinner fa-spin');
                    $('button > i', $form_wrapper).removeClass('fa-search');
                    $.ajax({
                        type: 'POST',
                        data: 'action=popup_search_result&keyword=' + keyword,
                        url: haru_framework_ajax_url,
                        success: function(data) {
                            $('button > i', $wrapper).removeClass('fa-spinner fa-spin');
                            $('button > i', $wrapper).addClass('fa-search');
                            var html = '';
                            var html_view_more = '';
                            if (data) {
                                var items = $.parseJSON(data);
                                if (items.length) {
                                    html += '<ul>';
                                    if (items[0]['id'] == -1) {
                                        html += '<li class="no-result">' + items[0]['title'] + '</li>';
                                    } else {
                                        $.each(items, function(index) {
                                            if (this['id'] == -2) {
                                                html_view_more = '<div class="search-view-more">' + this['title'] + '</div>';
                                            } else {
                                                if (index == 0) {
                                                    html += '<li class="selected">';
                                                } else {
                                                    html += '<li>';
                                                }
                                                if (this['title'] == null || this['title'] == '') {
                                                    html += '<a href="' + this['guid'] + '">' + this['date'] + '</a>';
                                                } else {
                                                    html += '<a href="' + this['guid'] + '">' + this['title'] + '</a>';
                                                }
                                                html += '</li>';
                                            }
                                        });
                                    }
                                    html += '</ul>';
                                } else {
                                    html = '';
                                }
                            }
                            if ($('.ajax-search-result', $form_wrapper).length == 0) {
                                $($form_wrapper).append('<div class="ajax-search-result"></div>');
                            }

                            $('.ajax-search-result', $wrapper).html(html + html_view_more);
                            $('.ajax-search-result ul', $wrapper).scrollTop(0);
                        },
                        error: function(data) {
                            $('button > i', $wrapper).removeClass('fa-spinner fa-spin');
                            $('button > i', $wrapper).addClass('fa-search');
                        }
                    });
                }
            });
        },
        searchCategory: function() {
            $('.search-with-category').each(function() {
                var $wrapperLeft = $('.form-search-left', this);
                var $wrapper = $(this);

                $(document).on('click', function(event) {
                    if ($(event.target).closest('.form-search-left', $wrapper).length === 0) {
                        $(' > ul', $wrapperLeft).slideUp();
                    }
                    if (($(event.target).closest('.form-search-right,.ajax-search-result', $wrapper).length === 0)) {
                        $('.ajax-search-result', $wrapper).remove();
                        $('input', $wrapper).val('');
                    }
                });

                var sHtml = '<li><span data-id="-1" data-value="' + $('> span', $wrapperLeft).text() + '">[' + $('> span', $wrapperLeft).text() + ']</span></li>';
                $('> ul', $wrapperLeft).prepend(sHtml);

                // Select Category
                $('> span', $wrapperLeft).on('click', function() {
                    $('> ul', $(this).parent()).slideToggle();
                });

                // Category Click
                $('li > span', $wrapperLeft).on('click', function() {
                    var $this = $(this);
                    var id = $this.attr('data-id');
                    var text = '';
                    if (typeof($this.attr('data-value')) != "undefined") {
                        text = $this.attr('data-value');
                    } else {
                        text = $this.text();
                    }

                    var $cate_current = $('> span', $wrapperLeft);
                    $cate_current.text(text);
                    $cate_current.attr('data-id', id);
                    $(' > ul', $wrapperLeft).slideUp();
                });

                // Search process
                //--------------------------------------------------------------------------------------
                var $inputSearch = $('input', $wrapper);
                $inputSearch.on('keyup', function(event) {
                    var s_timeOut_search = null;
                    if (event.altKey || event.ctrlKey || event.shiftKey || event.metaKey) {
                        return;
                    }

                    var keys = ["Control", "Alt", "Shift"];
                    if (keys.indexOf(event.key) != -1) return;
                    switch (event.which) {
                        case 37:
                        case 39:
                            break;
                        case 27: // ESC
                            $('.ajax-search-result', $wrapper).remove();
                            $(this).val('');
                            break;
                        case 38: // UP
                            HARU.search.up($('.ajax-search-result', $wrapper));
                            break;
                        case 40: // DOWN
                            HARU.search.down($('.ajax-search-result', $wrapper));
                            break;
                        case 13: //ENTER
                            var $item = $('.ajax-search-result li.selected a', $wrapper);
                            if ($item.length == 0) {
                                event.preventDefault();
                                return false;
                            }

                            window.location = $item.attr('href');

                            event.preventDefault();
                            return false;
                        default:
                            clearTimeout(s_timeOut_search);
                            s_timeOut_search = setTimeout(function() {
                                s_search($wrapper);
                            }, 1000);
                            break;
                    }
                });
            });

            function s_search($wrapper) {
                var keyword = $('input[type="text"]', $wrapper).val();
                if (keyword.length < 3) {
                    if ($('.ajax-search-result', $wrapper).length == 0) {
                        $($wrapper).append('<div class="ajax-search-result"></div>');
                    }
                    var hint_message = $wrapper.attr('data-hint-message');

                    $('.ajax-search-result', $wrapper).html('<ul><li class="no-result">' + hint_message + '</li></ul>');
                    return;
                }
                $('button > i', $wrapper).addClass('fa-spinner fa-spin');
                $('button > i', $wrapper).removeClass('fa-search');
                $.ajax({
                    type: 'POST',
                    data: 'action=result_search_product&keyword=' + keyword + '&cate_id=' + $('.form-search-left > span', $wrapper).attr('data-id'),
                    url: haru_framework_ajax_url,
                    success: function(data) {
                        $('button > i', $wrapper).removeClass('fa-spinner fa-spin');
                        $('button > i', $wrapper).addClass('fa-search');
                        var html = '';
                        var sHtmlViewMore = '';
                        if (data) {
                            var items = $.parseJSON(data);
                            if (items.length) {
                                html += '<ul>';
                                if (items[0]['id'] == -1) {
                                    html += '<li class="no-result">' + items[0]['title'] + '</li>';
                                } else {
                                    $.each(items, function(index) {
                                        if (this['id'] == -2) {
                                            sHtmlViewMore = '<div class="search-view-more">' + this['title'] + '</div>';
                                        } else {
                                            if (index == 0) {
                                                html += '<li class="selected">';
                                            } else {
                                                html += '<li>';
                                            }
                                            html += '<a href="' + this['guid'] + '">';
                                            html += this['thumb'];
                                            html += this['title'] + '</a>';
                                            html += '<div class="price">' + this['price'] + '</div>';
                                            html += '</li>';
                                        }

                                    });
                                }
                                html += '</ul>';
                            } else {
                                html = '';
                            }
                        }
                        if ($('.ajax-search-result', $wrapper).length == 0) {
                            $($wrapper).append('<div class="ajax-search-result"></div>');
                        }

                        $('.ajax-search-result', $wrapper).html(html + sHtmlViewMore);

                        $('.ajax-search-result li', $wrapper).hover(function() {
                            $('.ajax-search-result li', $wrapper).removeClass('selected');
                            $(this).addClass('selected');
                        });

                        $('.ajax-search-result ul', $wrapper).scrollTop(0);

                    },
                    error: function(data) {
                        $('button > i', $wrapper).removeClass('fa-spinner fa-spin');
                        $('button > i', $wrapper).addClass('fa-search');
                    }
                });
            }
        }
    };

    // Document ready
    HARU.onReady = {
        init: function() {
            HARU.common.init();
            HARU.page.init();
            HARU.base.init();
            HARU.blog.init();
            HARU.header.init();
        }
    };

    // Window resize
    HARU.onResize = {
        init: function() {
            HARU.header.windowResized();
        }
    }

    // Window onLoad
    HARU.onLoad = {
        init: function() {
            HARU.header.windowLoad();
            HARU.page.windowLoad();
        }
    }

    // Window onScroll
    HARU.onScroll = {
        init: function() {

        }
    }
    $(window).resize(HARU.onResize.init);
    $(window).scroll(HARU.onScroll.init);
    $(document).ready(HARU.onReady.init);
    $(window).load(HARU.onLoad.init);

})(jQuery);