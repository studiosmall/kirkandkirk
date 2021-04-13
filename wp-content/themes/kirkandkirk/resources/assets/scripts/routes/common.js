import AOS from 'aos';
import 'slick-carousel';
import Flickity from 'flickity';
import Plyr from 'plyr';
import 'jquery-visible';

//import '../vendor/masonry.pkgd.js';
import 'masonry-layout/dist/masonry.pkgd.min.js';

export default {
  init() {
    // JavaScript to be fired on all pages
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired

    //let lastScrollTop = 0;

    AOS.init({
      duration: 1000, // values from 0 to 3000, with step 50ms
      offset: -40,
    });

    window.addEventListener('load', AOS.refresh);
    window.addEventListener('resize', AOS.refresh);


    if ( $('.announcement').length > 0 ) {
      let i = 0
      let elem = document.querySelectorAll('.announcement__item')
      elem.forEach(el => el.classList.add('start'))
      const aniAnn = function() {
        let el = elem[i % elem.length]
        el.classList.add('in')
        el.classList.remove('start')
        setTimeout(function() {
          el.classList.remove('in')
          el.classList.add('out')
        }, 3000)
        setTimeout(function() {
          el.classList.add('start')
          el.classList.remove('out')
        }, 3600)
        i++
      }
      aniAnn()

      let interval = setInterval(aniAnn, 3000); // eslint-disable-line no-unused-vars

    }

    $('.header__hamburger').on('click', function(e){
      e.preventDefault();
      $(this).toggleClass('active');
      $('.off-canvas, body').toggleClass('active');
      $('.filter__container, .filter__title').removeClass('active');
    });

    // let onScroll = function() {
    //   let navbarHeight = $('.header').outerHeight();
    //   let st = $(this).scrollTop();
    //   // let navbarHeight = $('.header').outerHeight();
    //   //if (st > lastScrollTop && st >= navbarHeight ){
    //   if (st >= navbarHeight ){
    //     // downscroll code
    //     $('.header').addClass('small');

    //   } else {
    //     // upscroll code
    //     $('.header').removeClass('small');
    //   }
    //   // if (popup === null && $('.home .articles').length) {
    //   //   let latestNews = $('.home .articles').offset().top
    //   //   if (st > latestNews) {
    //   //     $('.newsletter-popup').fadeIn();
    //   //     popup = true;
    //   //   }
    //   // }
    //   //lastScrollTop = st;
    //   if (st > $(window).innerHeight()) {
    //     $('.header').addClass('scrolled');
    //   } else {
    //     $('.header').removeClass('scrolled');
    //   }
    // }
    // onScroll();
    // $(window).scroll(onScroll);



  // Review Slider
  function reviewSlider() {
    let $gallerySlider = $('.slider-review');
    $gallerySlider.each(function() {
      $(this).slick({
        autoplay: true,
        dots: false,
        arrows: true,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        adaptiveHeight: true,
        centerMode: false,
        initialSlide: 0,
        centerPadding: '10%',
        responsive: [
          {
            breakpoint: 812,
            settings: {
              centerPadding: '10%',
              slidesToShow: 1,
              slidesToScroll: 1,
            },
          },
          {
            breakpoint: 768,
            settings: {
              centerPadding: '10%',
              slidesToShow: 1,
              slidesToScroll: 1,
            },
          },
          {
            breakpoint: 600,
            settings: {
              centerPadding: '10px',
              slidesToShow: 1,
              slidesToScroll: 1,
            },
          },
          {
            breakpoint: 480,
            settings: {
              centerPadding: '10px',
              slidesToShow: 1,
              slidesToScroll: 1,
            },
          },
        ],
      });
    });
  }

  reviewSlider();


  // creates a node list of all carousels on the same page
  const carousels = document.querySelectorAll('.slider');

  carousels.forEach(carousel => {
    new Flickity(carousel, {
      prevNextButtons: false,
      pageDots: false,
      wrapAround: true,
      freeScroll: true,
    });
  });


    //
    // Video
    if($('.video').length ) {
      const player 	= new Plyr('#player', { // eslint-disable-line no-unused-vars
				muted: true,
			});


      //auto play video on scroll
      $(document).on( 'scroll', function(){
        if ($('.plyr__video-embed').visible(true)) {
          // The element is visible, do something
         player.play(); // eslint-disable-line no-undef

        } else {
          player.pause();
        }
      })
    }

    if($('.articles__items').length) {
      var $grid = $('.articles__items');
      // var $grid = $('.articles__items').imagesLoaded( function() {
        $grid.masonry({
          itemSelector: '.articles__card',
          percentPosition: true,
          columnWidth: '.articles__sizer',
          gutter: 40,
        });
      // });
    }

    if($('.wc360').length) {
      setTimeout(
        function() {
          $('.product-images__360').fadeIn();
        }, 1000);
    }

    if($('.filter').length) {
      $('.filter__title').on('click', function(e){
        e.preventDefault();
        $(this).toggleClass('active');
        $('.filter__container').toggleClass('active');
      });
    }

  },
};
