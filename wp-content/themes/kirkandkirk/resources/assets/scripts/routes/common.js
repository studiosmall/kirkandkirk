import AOS from 'aos';
import 'slick-carousel';
import Flickity from 'flickity';
import Plyr from 'plyr'; // eslint-disable-line
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

    if (window.location.href.indexOf('#optician') > -1) { // etc
      $('.off-canvas, body, .header__hamburger').addClass('active');
    }

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

    $('.off-canvas ul li.menu-item-has-children > a').click(function(e) {
      e.preventDefault();
      $(this).parent().toggleClass('active');
      $(this).next().slideToggle();
    });

    $('#search-btn').on('click', function(e){
      e.preventDefault();

      // $(this).toggleClass('hide');
      $('.header__search').toggleClass('active');
    });

    if($('.woocommerce-breadcrumb a').length) {
      let $first = $('.woocommerce-breadcrumb a').first();
      if($($first).text() == 'Optical') {
        $($first).attr('href','/collections/optical/');

        // setTimeout(function() {
        //     $($first).addClass('hello');
        // }, 1000);
      }
    }


    $('#share-icons').on('click', function(e){
      e.preventDefault();
      $(this).parent().toggleClass('active');
    });

    let onScroll = function() {
      let navbarHeight = $('.header').outerHeight();
      let st = $(this).scrollTop();
      // let navbarHeight = $('.header').outerHeight();
      //if (st > lastScrollTop && st >= navbarHeight ){
      if (st >= navbarHeight ){
        // downscroll code
        $('.header, .off-canvas').addClass('small');

      } else {
        // upscroll code
        $('.header, .off-canvas').removeClass('small');
      }
      // if (popup === null && $('.home .articles').length) {
      //   let latestNews = $('.home .articles').offset().top
      //   if (st > latestNews) {
      //     $('.newsletter-popup').fadeIn();
      //     popup = true;
      //   }
      // }
      //lastScrollTop = st;
      if (st > $(window).innerHeight()) {
        $('.header').addClass('scrolled');
      } else {
        $('.header').removeClass('scrolled');
      }
    }
    onScroll();
    $(window).scroll(onScroll);



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
    // Show similar product on single product 
    if($('.single-product-data, .single-product').length) {
      let similar = $('.related .flickity-slider li').size();

      console.log(similar + ' related');

      if(similar >= 2) {
        setTimeout(
          function() {
            console.log('resize fired recently') 
            $('.recently-slider').resize();
          }, 1000);
     
      } else {
        $('.related').css('display', 'none');
      }

    }

    if($('.single-product-data, .single-product').length) {
      let similar = $('.recently .flickity-slider .featured-products__product').size();
      console.log(similar + ' size');

      if(similar >= 1) {
        
        //

      } else {
        $('.recently').css('display', 'none');
      }
      
    }


    //
    // Video
    if($('.video').length ) {
      
        // This is the bare minimum JavaScript. You can opt to pass no arguments to setup.
      // e.g. just plyr.setup(); and leave it at that if you have no need for events
      const player = new Plyr.setup('.plyr__video-embed', {  // eslint-disable-line
        // Output to console
        debug: false,
        muted: true,
      });
      
      
      // const player 	= new Plyr('.plyr__video-embed', { // eslint-disable-line no-unused-vars
			// 	muted: true,
			// });

      // console.log('yes');
      // console.log(player);
      // console.log('yes');

      //document.querySelectorAll('.video')[0].player.play();

      if ($('body').hasClass('front-page-data')) {
        //auto play video on scroll
        $(document).on( 'scroll', function(){
          if ($('.plyr--video').visible(true)) {
            // The element is visible, do something
            player[0].play(); // eslint-disable-line no-undef

          } else {
            player[0].pause();
          }
        })   
      }
    }

    if($('.wc360').length) {
      // console.log('yes');
      setTimeout(
        function() {
          $('.product-images__360').css('display', 'flex');
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


    var $grid = $('.articles__items');

    // function updateMasonry() {
    //   var $containerHeight = $(window).width();

    //   console.log($containerHeight);

    //   if ($containerHeight >= 819) {

    //     // var $grid = $('.articles__items').imagesLoaded( function() {
    //       $grid.masonry({
    //         itemSelector: '.articles__card',
    //         percentPosition: true,
    //         columnWidth: '.articles__sizer',
    //         gutter: 40,
    //       });
    //       console.log('enable');
    //     // });
    //   } else {
    //     $grid.masonry();
    //     $grid.masonry('destroy');
    //     console.log('destroy');
    //   }
    // }

    if($('.articles__items').length) {

      // $(document).ready(function () {
      //   updateMasonry();

      //   $(window).resize(function() {
      //       updateMasonry();
      //   });
      // });

      $(document).on('click', '.moreless-button', function(e){
      // $('.moreless-button').on('click', function (e) {
        e.preventDefault();

        $(this).prev('.moretext').slideToggle();
        $(this).fadeOut();

        var $containerHeight = $(window).width();
        if ($containerHeight >= 819) {
          $grid.masonry();
        }

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

                var $containerHeight = $(window).width();
                if ($containerHeight >= 819) {
                  //container.masonry('appended', $items);
                  setTimeout( function(){
                    container.append( $items ).masonry( 'appended', $items );
                  }, 500);
                }

                let count = $('.articles__card').length;
                $('.articles__items').attr('data-offset', count);
              }
            },
          });
        }
      });


      // Newsletter
      $('#newsletter-popup').on('click', function(e) {
        e.preventDefault();
        $('#mailinglist').fadeIn();
        $('body').toggleClass('newsletter-open');
        $('.overlay').toggleClass('open');
      });

      $('.mailinglist__close').on('click', function() {
        $('#mailinglist').fadeOut();
        $('body').removeClass('newsletter-open');
        $('.overlay').removeClass('open');
      });


      if($('.filter__container').length) {
        if (window.location.href.indexOf('filter_') > -1) {
          $('.filter__container, .filter__title').addClass('active');
        }
      }



        $('.optician_single_add_to_cart_button').on('click', function() {

          console.log('in her');

            //let variation_id = $('input.variation_id').val();
            let variation_id = $(this).val();

            if (variation_id != 0) {
                //let $form_selector = $('form.variations_form');
                //let formdata = getFormData($form_selector);
                //let formdata = getFormData(variation_id);

                //console.log(formdata);

                //let formdata = {'attribute_pa_color':'reds-pinks','quantity':'1','wlid':'','add-to-wishlist-type':'variable','wl_from_single_product':'1','add-to-cart':'305','product_id':'305','variation_id':'305'};
                let formdata = {'quantity':'1','wl_from_single_product':'1','add-to-cart':variation_id,'product_id':variation_id,'variation_id':variation_id};

                console.log(formdata);

                $.ajax({
                    type: 'POST',
                    // url: MyAjax.ajaxurl,
                    url: window.siteOptions.ajaxurl,
                    data: {
                        'action': 'hb_optician_single_add_to_cart_data',
                        'formdata': formdata,
                    },
                    success: function(result) {
                        console.log('aa=>' + result);

                       //throw new Error(formdata);

                        window.location.href = result;   // eslint-disable-line  no-unreachable
                    },
                    error: function(xhr, resp, text) {
                        console.log(xhr, resp, text);
                    },
                });
            } else {
                alert('Please select some product options before adding this product to your cart.');
            }
        });


        $('.optician_variable_add_to_cart_button').on('click', function() {
          console.log('clicked');

            //let variation_id = $('input.variation_id').val();
            let variation_id = $(this).val();
            console.log(variation_id);

            if (variation_id != 0) {
                let $form_selector = $('form.variations_form');
                let formdata = getFormData($form_selector);
                //let formdata = getFormData(variation_id);

                  console.log('here');
                  console.log(formdata);


                $.ajax({
                    type: 'POST',
                    // url: MyAjax.ajaxurl,
                    url: window.siteOptions.ajaxurl,
                    data: {
                        'action': 'hb_optician_add_to_cart_data',
                        'formdata': formdata,
                    },
                    success: function(result) {
                        console.log('aa=>' + result);

                        throw new Error(formdata);

                        window.location.href = result;   // eslint-disable-line  no-unreachable
                    },
                    error: function(xhr, resp, text) {
                        console.log(xhr, resp, text);
                    },
                });
            } else {
                alert('Please select some product options before adding this product to your cart.');
            }
        });

        $('.optician_remove_item').on('click', function() {
            let variation_id = $(this).data('variation_id');
            let variation_title = $(this).data('variation_title');  // eslint-disable-line no-unused-vars
            /*alert(variation_id);*/
            $.ajax({
                type: 'POST',
                // url: MyAjax.ajaxurl,
                url: window.siteOptions.ajaxurl,
                data: {
                    'action': 'hb_optician_remove_item',
                    'variation_id': variation_id,
                },
                success: function(result) {
                    console.log('aa=>' + result);
                    window.location.href = result;
                },
                error: function(xhr, resp, text) {
                    console.log(xhr, resp, text);
                },
            });
        });
    
        $('.optician-checkout-button').on('click', function() {
            let references = [];
            $('form.woocommerce-otician-cart-form textarea#reference ')
                .each(function() {
                    let current_value = $(this).val();
                    references.push(current_value);
                });
    
            let name_of_store = $('form.woocommerce-otician-cart-form #js_name_of_store').val();
            let ordernote = $('form.woocommerce-otician-cart-form textarea#js_ordernote ').val();
            $.ajax({
                type: 'POST',
                // url: MyAjax.ajaxurl,
                url: window.siteOptions.ajaxurl,
                data: {
                    'action': 'hb_optician_checkout_order',
                    references,
                    ordernote,
                    name_of_store,
                },
                success: function(result) {
                    console.log('mail=>' + result);
                    window.location.href = result;
                },
                error: function(xhr, resp, text) {
                    console.log(xhr, resp, text);
                },
            });
        });

        function getFormData($form) {
            let unindexed_array = $form.serializeArray();
            let indexed_array = {};

            $.map(unindexed_array, function(n, i) { // eslint-disable-line no-unused-vars
                indexed_array[n['name']] = n['value'];
            });

            return indexed_array;
        }
  






























  },
};
