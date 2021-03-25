import AOS from 'aos';
import 'slick-carousel';
import Flickity from 'flickity';

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




  //
  // Product Slider
  // function productSlider() {
  //   let $gallerySlider = $('.slider');
  //   $gallerySlider.each(function() {
  //     $(this).slick({
  //       autoplay: false,
  //       dots: true,
  //       arrows: true,
  //       infinite: false,
  //       slidesToShow: 3,
  //       slidesToScroll: 1,
  //       adaptiveHeight: false,
  //       centerMode: false,
  //       initialSlide: 0,
  //       centerPadding: '10%',
  //       responsive: [
  //         {
  //           breakpoint: 812,
  //           settings: {
  //             centerPadding: '10%',
  //             slidesToShow: 1.4,
  //             slidesToScroll: 1,
  //           },
  //         },
  //         {
  //           breakpoint: 768,
  //           settings: {
  //             centerPadding: '10%',
  //             slidesToShow: 1.4,
  //             slidesToScroll: 1,
  //           },
  //         },
  //         {
  //           breakpoint: 600,
  //           settings: {
  //             centerPadding: '10px',
  //             slidesToShow: 1.4,
  //             slidesToScroll: 1,
  //           },
  //         },
  //         {
  //           breakpoint: 480,
  //           settings: {
  //             centerPadding: '10px',
  //             slidesToShow: 1.4,
  //             slidesToScroll: 1,
  //           },
  //         },
  //       ],
  //     });
  //   });
  // }

  //productSlider();

  var flky = new Flickity( '.slider', {  // eslint-disable-line no-unused-vars
    // disable previous & next buttons and dots
    prevNextButtons: false,
    pageDots: false,
    wrapAround: true,
    freeScroll: true,
  });


  },
};
