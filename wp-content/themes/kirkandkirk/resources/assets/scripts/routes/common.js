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

    $('#search-btn').on('click', function(e){
      e.preventDefault();

      // $(this).toggleClass('hide');
      $('.header__search').toggleClass('active');
    });

    if($('.woocommerce-breadcrumb a').length) {
      let $first = $('.woocommerce-breadcrumb a').first();
      if($($first).text() == 'Optical') {
        $($first).attr('href','/shop/optical/');

        // setTimeout(function() {
        //     $($first).addClass('hello');
        // }, 1000);
      }
    }


    $('#share-icons').on('click', function(e){
      e.preventDefault();
      $(this).parent().toggleClass('active');
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

    if($('#wpsl-wrap').length) {
      $('#wpsl-search-input').focus(function(){
        $(this).attr('placeholder','');
      });
      $('#wpsl-search-input').focusout(function(){
        $(this).attr('placeholder','YOUR LOCATION');
      });
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

      $(document).on('click', '.moreless-button', function(e){
      // $('.moreless-button').on('click', function (e) {
        e.preventDefault();

        $(this).prev('.moretext').slideToggle();
        $(this).fadeOut();

        $grid.masonry();

        // if ($('.moreless-button').text() == 'Read More') {
        //   $(this).text('Read Less')
        // } else {
        //   $(this).text('Read More')
        // }
      });
    }

    let container = $('.articles__items');

      $('.more-articles').on('click', function (e) {
        e.preventDefault();

        if ($('.more-articles').hasClass('disabled')) {
         //
        } else {
          let filter = $('.filter__select').val();
          let offset = parseInt($('.articles__items').attr('data-offset'));
          // let search = $('.search-overlay input[type='search']').val();
  
          $('.more-articles').text('Loading ...').addClass('disabled');
  
          $.ajax({
            type: 'POST',
            url: window.siteOptions.ajaxurl,
            data: {
              action: 'kirkandkirk_more_articles',
              offset: offset,
              // search: search,
              category: filter,
            },
            success: function(result) {
              if ( result == 'none' ) {
                $('.more-articles').text('No more posts...').addClass('disabled');
              } else {
  
                $('.more-articles').text('Load More').removeClass('disabled');
                //$('.articles__items').append(result);
  
                var items = result;
                // make jQuery object
                var $items = $(items).hide();
                container.append($items);
  
                $items.show();
  
                //container.masonry('appended', $items);
                setTimeout( function(){
                  container.append( $items ).masonry( 'appended', $items );
                }, 100);
  
  
                let count = $('.articles__card').length;
                $('.articles__items').attr('data-offset', count);
              }
            },
          });
        }
      });


  },
};
