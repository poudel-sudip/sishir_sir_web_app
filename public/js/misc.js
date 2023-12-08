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

function getPageURLWithoutProtocol() {
    let pageURL = window.location.href;
    const protocol = window.location.protocol;
    
    if (pageURL.startsWith(protocol + '//')) {
        pageURL = pageURL.slice(protocol.length); // Remove protocol
    }

    return pageURL;
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



