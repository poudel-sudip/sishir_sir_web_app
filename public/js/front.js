/******/
(() => { // webpackBootstrap
    /******/
    var __webpack_modules__ = ({

        /***/
        "./resources/js/components/dynamicVideoModule.js":
        /*!*******************************************************!*\
          !*** ./resources/js/components/dynamicVideoModule.js ***!
          \*******************************************************/
        /***/
            (() => {

            $(document).ready(function() {
                $('.view-video').on('click', function() {
                    var videourl = $(this).attr('video-url');
                    var videotitle = $(this).attr('video-title');
                    var videoModal = $('#videoModal').modal();
                    var detectorResponse = detector(videourl);
                    var finalPlayer = getVideoPlayer(detectorResponse);
                    var videoPlayer = $('#videoPlayer');
                    videoPlayer.html('');
                    videoModal.on('shown.bs.modal', function() {
                        videoPlayer.html(''); // $('#playingVideo').attr('src',videourl);

                        $('#playingTitle').html(videotitle);
                        videoPlayer.append(finalPlayer);
                    });
                    videoModal.on('show.bs.modal', function() {
                        videoPlayer.html(''); // $('#playingVideo').attr('src',videourl);

                        $('#playingTitle').html(videotitle);
                        videoPlayer.append(finalPlayer);
                    });
                    videoModal.on('hide.bs.modal', function() {
                        videoPlayer.html(''); // $('#playingVideo').attr('src',videourl);

                        $('#playingTitle').html('Null');
                        videoPlayer.html('');
                    });
                }); //function to detect the id and platform (youtube, vimeo, dailymotion or uploaded) of the videos

                function detector(videoUrl) {
                    // var getVideoUrl     = videoUrl.parts.videoUrl;
                    var url = videoUrl;
                    var id = '';
                    var player = '';
                    var url_check = '';

                    if (url.indexOf('youtu.be') >= 0) {
                        player = 'youtube';
                        id = url.substring(url.lastIndexOf("/") + 1, url.length);
                    }

                    if (url.indexOf("youtube") >= 0) {
                        player = 'youtube';

                        if (url.indexOf("</iframe>") >= 0) {
                            var fin = url.substring(url.indexOf("embed/") + 6, url.length);
                            id = fin.substring(fin.indexOf('"'), 0);
                        } else {
                            if (url.indexOf("&") >= 0) id = url.substring(url.indexOf("?v=") + 3, url.indexOf("&"));
                            else id = url.substring(url.indexOf("?v=") + 3, url.length);
                        }

                        url_check = "https://gdata.youtube.com/feeds/api/videos/" + id + "?v=2&alt=json"; //"https://gdata.youtube.com/feeds/api/videos/" + id + "?v=2&alt=json"
                    }

                    if (url.indexOf("vimeo") >= 0) {
                        player = 'vimeo';

                        if (url.indexOf("</iframe>") >= 0) {
                            var fin = url.substring(url.lastIndexOf('vimeo.com/"') + 6, url.indexOf('>'));
                            id = fin.substring(fin.lastIndexOf('/') + 1, fin.indexOf('"', fin.lastIndexOf('/') + 1));
                        } else {
                            id = url.substring(url.lastIndexOf("/") + 1, url.length);
                        }

                        url_check = 'http://vimeo.com/api/v2/video/' + id + '.json'; //'http://vimeo.com/api/v2/video/' + video_id + '.json';
                    }

                    if (url.indexOf('dai.ly') >= 0) {
                        player = 'dailymotion';
                        id = url.substring(url.lastIndexOf("/") + 1, url.length);
                    }

                    if (url.indexOf("dailymotion") >= 0) {
                        player = 'dailymotion';

                        if (url.indexOf("</iframe>") >= 0) {
                            var fin = url.substring(url.indexOf('dailymotion.com/') + 16, url.indexOf('></iframe>'));
                            id = fin.substring(fin.lastIndexOf('/') + 1, fin.lastIndexOf('"'));
                        } else {
                            if (url.indexOf('_') >= 0) id = url.substring(url.lastIndexOf('/') + 1, url.indexOf('_'));
                            else id = url.substring(url.lastIndexOf('/') + 1, url.length);
                        }

                        url_check = 'https://api.dailymotion.com/video/' + id; // https://api.dailymotion.com/video/x26ezrb
                    }

                    if (url.indexOf('vidyard') >= 0) {
                        player = 'vidyard';
                        id = url.substring(url.lastIndexOf("/") + 1, url.indexOf("?"));
                    }

                    if (url.indexOf('zoom') >= 0) {
                        player = 'zoom';
                        id = url;
                    }

                    if (player === '' && id === '') {
                        player = 'uploaded';
                        id = url;
                    }

                    return {
                        'player': player,
                        'video_id': id
                    };
                } //detect the video and set the player


                function getVideoPlayer(response) {
                    var url = "";
                    var player = "";

                    if (response.player == "youtube") {
                        url = "https://www.youtube.com/embed/" + response.video_id + "?autohide=1&controls=1&showinfo=1";
                        player = "<iframe\n                                    id=\"playingVideo\"\n                                    class=\"embed-responsive-item\"\n                                    src=\"".concat(url, "\"\n                                    frameborder=\"0\"\n                                    width=\"100%\"\n                                    allowfullscreen\n                                    style=\"min-width: 30vw;min-height: 30vh;\">\n\n                             </iframe>");
                    } else if (response.player == "vimeo") {
                        url = "https://player.vimeo.com/video/" + response.video_id + "?portrait=0";
                        player = "<iframe\n                                    id=\"playingVideo\"\n                                    class=\"embed-responsive-item\"\n                                    src=\"".concat(url, "\"\n                                    frameborder=\"0\"\n                                    width=\"100%\"\n                                    allowfullscreen\n                                    style=\"min-width: 30vw;min-height: 30vh;\">\n\n                             </iframe>");
                    } else if (response.player == "dailymotion") {
                        url = "https://www.dailymotion.com/embed/video/" + response.video_id;
                        player = "<iframe\n                                    id=\"playingVideo\"\n                                    class=\"embed-responsive-item\"\n                                    src=\"".concat(url, "\"\n                                    frameborder=\"0\"\n                                    width=\"100%\"\n                                    allowfullscreen\n                                    style=\"min-width: 30vw;min-height: 30vh;\">\n\n                             </iframe>");
                    } else if (response.player == "vidyard") {
                        player = "<iframe \n                class=\"vidyard_iframe embed-responsive-item\"\n                id=\"playingVideo\"\n                src=\"//play.vidyard.com/".concat(response.video_id, ".html?\" \n                width=\"100%\" scrolling=\"no\" \n                frameborder=\"0\" \n                allowtransparency=\"true\" \n                allowfullscreen\n                style=\"min-width: 30vw;min-height: 30vh;\">\n                </iframe>");
                    } else if (response.player == "zoom") {
                        player = "<div class=\"text-center text-white align-self-center\">\n                <p><a href=\"".concat(response.video_id, "\" target=\"_blank\" class=\"btn btn-danger\" style=\"background-color:red\">Click Here To Play The Zoom Video</a></p>\n            </div>");
                    } else if (response.player == "uploaded") {
                        url = response.video_id;
                        player = "<video\n                        id=\"playingVideo\"\n                        class=\"embed-responsive-item\"\n                        width=\"100%\"\n                        height=\"100%\"\n                        src=\"".concat(url, "\"\n                        allowfullscreen\n                        controls\n\n                      controlsList='nodownload'>\n\n                        </video>");
                    }

                    return player;
                }
            }); //home page player

            $(document).ready(function() {
                $('.play_video_btn').click(function() {
                    console.log('hello');
                    $('#video_iframe').attr('src', '');
                    var videoID = $(this).attr('video-id');
                    var src = "https://www.youtube.com/embed/" + videoID + "?autohide=1&controls=1&showinfo=1";
                    $('#video_iframe').attr('src', src);
                });
            });

            /***/
        }),

        /***/
        "./resources/js/components/main.js":
        /*!*****************************************!*\
          !*** ./resources/js/components/main.js ***!
          \*****************************************/
        /***/
            (() => {

            // $(document).ready(function() {
            //     $(".dropdown").hover(function() {
            //         $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true, true).slideDown("400");
            //         $(this).toggleClass('open');
            //     }, function() {
            //         $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true, true).slideUp("400");
            //         $(this).toggleClass('open');
            //     });
            // });
            // main slider

            $('.main-slider').owlCarousel({
                smartSpeed: 500,
                nav: true,
                loop: true,
                lazyLoad: true,
                autoplayTimeout: 8000,
                autoplayHoverPause: true,
                animateOut: 'fadeOut',
                animateIn: 'fadeIn',
                autoplay: true,
                navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
                responsive: {
                    0: {
                        items: 1,
                        nav: false
                    },
                    600: {
                        items: 1
                    },
                    1000: {
                        items: 1
                    }
                }
            }); // course-carousel

            $('.course-carousel').owlCarousel({
                items: 3,
                smartSpeed: 500,
                nav: true,
                loop: true,
                lazyLoad: true,
                navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
                responsive: {
                    0: {
                        items: 1,
                        nav: false
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 3
                    }
                }
            });
            $('.course-carousel').find('.owl-nav').removeClass('disabled');
            $('.course-carousel').on('changed.owl.carousel', function(event) {
                $(this).find('.owl-nav').removeClass('disabled');
            }); // course-carousel

            $('.review-slider').owlCarousel({
                items: 3,
                smartSpeed: 400,
                loop: true,
                nav: true,
                navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                        nav: false
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 3
                    }
                }
            });
            $('#top-tutors-slider').owlCarousel({
                items: 4,
                smartSpeed: 600,
                nav: true,
                loop: true,
                navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 4
                    }
                }
            });

            // mcq slider
            $('.MCQ-exam').owlCarousel({
                smartSpeed: 600,
                nav: true,
                loop: false,
                navText: ['<span><i class="fa fa-chevron-left"></i> Previous</span>', '<span>Next <i class="fa fa-chevron-right"></i></span>'],
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    1000: {
                        items: 1
                    }
                }
            });

            // chapter image slide
            $('.chapter-file-carousel').owlCarousel({
                smartSpeed: 600,
                nav: true,
                loop: false,
                navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    1000: {
                        items: 1
                    }
                }
            });

            // for summer note
            $(document).ready(function() {
                $('.summernote').summernote({
                    height: 200,
                });
            });
            /***/
        })

        /******/
    });
    /************************************************************************/
    /******/ // The module cache
    /******/
    var __webpack_module_cache__ = {};
    /******/
    /******/ // The require function
    /******/
    function __webpack_require__(moduleId) {
        /******/ // Check if module is in cache
        /******/
        var cachedModule = __webpack_module_cache__[moduleId];
        /******/
        if (cachedModule !== undefined) {
            /******/
            return cachedModule.exports;
            /******/
        }
        /******/ // Create a new module (and put it into the cache)
        /******/
        var module = __webpack_module_cache__[moduleId] = {
            /******/ // no module.id needed
            /******/ // no module.loaded needed
            /******/
            exports: {}
            /******/
        };
        /******/
        /******/ // Execute the module function
        /******/
        __webpack_modules__[moduleId](module, module.exports, __webpack_require__);
        /******/
        /******/ // Return the exports of the module
        /******/
        return module.exports;
        /******/
    }
    /******/
    /************************************************************************/
    var __webpack_exports__ = {};
    // This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
    (() => {
        /*!*******************************!*\
          !*** ./resources/js/front.js ***!
          \*******************************/
        // require('./components/coursebatches');
        __webpack_require__( /*! ./components/dynamicVideoModule */ "./resources/js/components/dynamicVideoModule.js");

        __webpack_require__( /*! ./components/main */ "./resources/js/components/main.js");
    })();

    /******/
})();