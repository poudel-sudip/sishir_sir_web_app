// var popupSize = {
//     width: 780,
//     height: 550
// };

// $(document).on('click', '.social-button', function (e) {
//     var verticalPos = Math.floor(($(window).width() - popupSize.width) / 2),
//         horisontalPos = Math.floor(($(window).height() - popupSize.height) / 2);

//     var popup = window.open($(this).prop('href'), 'social',
//         'width=' + popupSize.width + ',height=' + popupSize.height +
//         ',left=' + verticalPos + ',top=' + horisontalPos +
//         ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');

//     if (popup) {
//         popup.focus();
//         e.preventDefault();
//     }

// });

$( document ).ready(function() {
  new WOW().init();

  // Attach a handler to the 'wow' animation end event
  $('.wow').on('animationstart', function() {
    // Start the counter animation after the 'wow' animation ends
    $('.counter-count').each(function() {
      $(this).prop('Counter', 0).animate({
        Counter: $(this).text()
      }, {
        duration: 2500,
        easing: 'swing',
        step: function(now) {
          $(this).text(Math.ceil(now));
        }
      });
    });
  });
})


function getPageURLWithoutProtocol() {
  // Use the window.location object to get the path without query parameters
  let path = window.location.pathname; // This gives the path part of the URL
    
  // If there are any hash fragments, remove them
  const hashIndex = path.indexOf('#');
  if (hashIndex !== -1) {
      path = path.substring(0, hashIndex);
  }
  
  return path;

  // let pageURL = window.location.href;
  // const protocol = window.location.protocol;
  
  // if (pageURL.startsWith(protocol + '//')) {
  //     pageURL = pageURL.slice(protocol.length); // Remove protocol
  // }

  // return pageURL;
}

function postDataWithFetch(url = '', data = {}) {

    let stringss = JSON.stringify(data);
    return fetch(url+'?data='+stringss, {
        method: 'get',
        headers: {
            'Content-Type': 'application/json',
            // 'X-CSRF-TOKEN': '{{ csrf_token() }}',
            // Add any additional headers if needed
        },
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json(); // Parse JSON response
    })
    .then(result => {
        // Handle the result or response here
        console.log(result);
    })
    .catch(error => {
        // Handle errors here
        console.error('There was a problem with the fetch operation:', error);
    });
}

function calculateReadingTime() {

  const mainContent = document.getElementById("main-area-content");
  if (!mainContent) {
    console.warn("No element with ID 'main-area-content' found!");
    return;
  }

  const WORDS_PER_MINUTE = 250; // Average reading speed

  const content = mainContent.cloneNode(true);

  // Remove non-readable elements
  const elementsToRemove = content.querySelectorAll(
    "script, style, noscript, svg, canvas, iframe, video, audio"
  );
  elementsToRemove.forEach(el => el.remove());

  // Get text
  const text = content.textContent || "";
  const words = text.trim().split(/\s+/).filter(Boolean);
  const wordCount = words.length;

  // Base reading time (text only)
  let minutes = wordCount / WORDS_PER_MINUTE;

  return {
    estimatedMinutes: Math.ceil(minutes)
  };
}


$('.eb-seller-carousel').owlCarousel({
  items: 5,
  smartSpeed: 500,
  margin:20,
  nav: true,
  loop: true,
  lazyLoad: true,
  autoplayTimeout: 5000,
  autoplayHoverPause: false,
  autoplay: true,
  navText: ['<i class="fas fa-caret-left"></i>', '<i class="fas fa-caret-right"></i>'],
  responsive: {
    0: {
      items: 1,
      nav: false
    },
    540: {
      items: 2
    },
    768: {
      items: 3
    },
    1000: {
      items: 4
    }
  }
});

// mcq slider
// $('.MCQ-List').owlCarousel({
//   smartSpeed: 600,
//   // nav: true,
//   loop: false,
//   // navText: ['<span><i class="fa fa-chevron-left"></i> Previous Page </span>', '<span>Next Page <i class="fa fa-chevron-right"></i></span>'],
//   responsive: {
//       0: {
//           items: 1
//       },
//       600: {
//           items: 1
//       },
//       1000: {
//           items: 1
//       }
//   }
// });

var back_to_top_btn = $('#back_to_top');

back_to_top_btn.on('click', function(e) {
  e.preventDefault();
  $('html, body').animate({scrollTop:0}, '300');
});


    

document.addEventListener("DOMContentLoaded", function () {

  const categorySwipers  = document.querySelectorAll('.category-swiper');
  categorySwipers.forEach(el => {

    // const nextBtn = el.querySelector('.swiper-button-next');
    // const prevBtn = el.querySelector('.swipSer-button-prev');
    const prevBtn = el.previousElementSibling;
    const nextBtn = el.nextElementSibling;

    const swiper = new Swiper(el, {
      slidesPerView: "auto",
      // spaceBetween: 8,
      freeMode: true,
      grabCursor: true,
      navigation: {
        nextEl: nextBtn,
        prevEl: prevBtn,
      }
    });

    const tabButtons = el.querySelectorAll('.nav-link');
    tabButtons.forEach(button => {
      button.addEventListener('click', function () {
        tabButtons.forEach(btn => {
          btn.classList.remove('active');
          btn.setAttribute('aria-selected', 'false');
        });

        this.classList.add('active');
        this.setAttribute('aria-selected', 'true');
      });
    });

    const activeIndex = [...tabButtons].findIndex(btn =>
      btn.classList.contains('active')
    );

    if (activeIndex !== -1) {
      swiper.slideTo(activeIndex, 0);
    }
  });

  function startMarquee() {
    const tracks = document.querySelectorAll('.marquee .marquee-content');
    const speed = 30; // px per second
    tracks.forEach(track => {
      let position = 0;
      track.innerHTML += track.innerHTML;
      const totalWidth = track.scrollWidth / 2;
      function animate() {
        position -= speed / 60;

        if (Math.abs(position) >= totalWidth) {
            position = 0;
        }

        track.style.transform = `translateX(${position}px)`;
        requestAnimationFrame(animate);
      }

      animate();
    });

  }

  startMarquee();
});
  
function formatYoutubeCount(count) {
  if (count < 1000) {
      return count.toString();
  } else if (count < 1000000) {
      return (count / 1000).toFixed(2) + 'K';
  } else if (count < 1000000000) {
      return (count / 1000000).toFixed(2) + 'M';
  } else {
      return (count / 1000000000).toFixed(2) + 'B';
  }
}

// Function to fetch channel details
function fetchChannelDetails(channelId, apiKey) {
  fetch(`https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id=${channelId}&key=${apiKey}`)
  .then(response => response.json())
  .then(data => {
      const channel = data.items[0];
      const snippet = channel.snippet;
      const statistics = channel.statistics;

      // document.getElementById('youtube-channel-thumbnail').src = snippet.thumbnails.default.url;
      document.getElementById('youtube-channel-title').textContent = snippet.title;
      document.getElementById('youtube-subscriber-count').textContent = `Subscribers: ${formatYoutubeCount(statistics.subscriberCount)}`;
      document.getElementById('youtube-video-count').textContent = `Videos: ${formatYoutubeCount(statistics.videoCount)}`;
      document.getElementById('youtube-view-count').textContent = `Views: ${formatYoutubeCount(statistics.viewCount)}`;

  })
  .catch(error => console.error('Error fetching channel details:', error));
}

// Call the function with your channel ID and API key
fetchChannelDetails('UCSFeHpNoMSF-BBgsDtro0zw', 'AIzaSyBxr-THTyWsKMxKrtE_wBJ1r_6OT4zlry8'); //shisir sir

