<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--<meta content="text/html; charset=utf-8" http-equiv="Content-Type">-->
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>@yield('page_title') | {{ config('app.name') }}</title>
  {{-- <meta name="description" content="Mr. Shisir Kumar Adhikari is a government job holder public health practitioner, young academician, good trainer and author of Mentor Series Books."> --}}
  <meta name="description" content="@yield('og-description','')" >
  <meta name="keywords" content="health loksewa, health, books, shishir adhikari, shishir sir, shisir adhikari, loksewa, loksewa health, shishir loksewa, psc, psc health ">
  
  <meta property="og:type" content="article" />
  <meta property="og:site_name" content="Shisir Adhikari" />
  <meta property="og:title" content="@yield('og-title','')" />
  <meta property="og:url" content="@yield('og-url', url(''))" />
  <meta property="og:image" content="@yield('og-image', asset('images/default-post.png'))" />
  <meta property="og:image:alt" content="{{asset('images/default-post.png')}}" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="630" />
  <meta property="og:description" content="@yield('og-description','')" />

  <meta name="google-adsense-account" content="ca-pub-1675260624457509">
  
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZS3KVP4N6H"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
  
    gtag('config', 'G-ZS3KVP4N6H');
  </script>

  

  <link href="{{ asset('css/front.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet">

  <!-- Scripts -->
  <script src="{{ asset('js/libraries/jquery-3.6.0.min.js') }}"></script>
  {{-- <script type="text/javascript" async src="https://play.vidyard.com/embed/v4.js"></script> --}}
  <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=63ce36b638862e00198c0bcc&product=inline-share-buttons&source=platform" async="async"></script> 
  <script src="{{ asset('js/app.js') }}" defer></script>   
  
  @yield('page-header-content')

  <style>
    body{
      overflow-x: hidden;
    }
  </style>
  
</head>
<body>  

  <?php 
    $page_title = View::getSection('page_title', '');
    // $page_url = "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    $page_url = strtok($_SERVER['REQUEST_URI'], '?');
    $view_count = Helper::addViewCount($page_title,$page_url);
  ?>

  @include('front.includes.header')

  @yield('content')

  @include('front.includes.footer')

  <!-- Back to top button -->
  {{-- <div class="back-to-top" id="back_to_top"> <i class="fa fa-angle-up"></i></div> --}}
  <div class="back-to-top-container">
    <svg class="progress-ring" viewBox="0 0 100 100">
        <circle class="progress-ring-border" cx="50" cy="50" r="36" stroke-width="1" />
        <circle class="progress-ring-background" cx="50" cy="50" r="35" stroke-width="6" />
        <circle class="progress-ring-bar" cx="50" cy="50" r="35" stroke-width="6" stroke-dasharray="282.74" stroke-dashoffset="282.74" />
    </svg>
    <button id="backToTop" class="back-to-top">
        <i class="fas fa-level-up-alt"></i>
    </button>
</div>


  <script src="{{ asset('js/libraries/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/libraries/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('js/libraries/wow.min.js') }}"></script>
  {{--<script src="{{ asset('js/main.js') }}"></script>--}}

  {{--  <script src="{{ asset('js/libraries.js') }}"></script>--}}
  
  <script type="text/javascript">
    function googleTranslateElementInit() {
      new google.translate.TranslateElement({
        pageLanguage: '', // default language of your site
        includedLanguages: 'en,ne', // languages you want to support
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
      }, 'google_translate_element');
    }
  </script>

  <script type="text/javascript" 
    src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
  </script>

  <script src="{{ asset('js/front.js') }}"></script>

  {{-- <script type="text/javascript" src="{{asset('js/noprint.js')}}"></script> --}}
  <script type="text/javascript" src="{{asset('js/misc.js')}}"></script>

  @yield('page-footer-content')

  {{-- <script>
    function adjustFontSize() {
      let zoomLevel = Math.round(window.devicePixelRatio * 100); 
      let baseFontSize = 16; 
      let newFontSize = baseFontSize - Math.floor((zoomLevel - 100) / 10); 
      newFontSize = Math.max(newFontSize, 10);

      let elements = {
        "body": newFontSize,
        "h1": newFontSize + 10, 
        "h2": newFontSize + 8, 
        "h3": newFontSize + 6,
        "h4": newFontSize + 4,
        "h5": newFontSize + 2,
        "p": newFontSize, 
        "a": newFontSize + 1, 
        "div": newFontSize, 
        "span": newFontSize, 
        "button": newFontSize, 
      };

      for (let tag in elements) {
        document.querySelectorAll(tag).forEach(el => {
          el.style.fontSize = `${elements[tag]}px`;
        });
      }
    }
    window.addEventListener("resize", adjustFontSize);
    adjustFontSize();
  </script> --}}

  <script>
    $(document).ready(function () {
      const $progressRingBar = $('.progress-ring-bar');
      const $progressRing = $('.progress-ring');
      const $backToTopButton = $('#backToTop');

      // Function to update progress based on scroll position
      function updateScrollProgress() {
          const scrollTop = $(document).scrollTop();
          const documentHeight = $(document).height() - $(window).height();
          const scrollPercentage = (scrollTop / documentHeight) * 100;

          // Calculate stroke dashoffset to reflect scroll progress (range 0-282.74)
          const dashoffset = 282.74 - (scrollPercentage / 100) * 282.74;
          $progressRingBar.css('stroke-dashoffset', dashoffset);
      }

      // Function to handle back-to-top button click and 360-degree rotation
      function scrollToTop() {
          // Start the 360-degree rotation animation
          $backToTopButton.css({
              'transition': 'transform 1s ease',
              'transform': 'rotate(360deg)'
          });

          // Scroll the page to the top after rotation is complete
          setTimeout(function () {
              $('html, body').animate({ scrollTop: 0 }, 'smooth');
               $backToTopButton.css('transform', 'rotate(0deg)');
          }, 1000);  // Delay to let the rotation animation finish
      }

      // Show and hide back-to-top button based on scroll position
      $(window).scroll(function () {
          updateScrollProgress();
          if ($(window).scrollTop() > 200) {
              $backToTopButton.fadeIn();
              $progressRing.fadeIn();
          } else {
              $backToTopButton.fadeOut();
              $progressRing.fadeOut();
          }
      });

      // Listen for back-to-top button click
      $backToTopButton.click(function () {
          scrollToTop();
      });
  });

  </script>

</body>
</html>
