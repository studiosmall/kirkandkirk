import AOS from 'aos';

export default {
  init() {
    // JavaScript to be fired on all pages
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired

    //let lastScrollTop = 0;

    AOS.init({
      duration: 1000, // values from 0 to 3000, with step 50ms
      offset: 0,
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


    let onScroll = function() {
      let navbarHeight = $('.header').outerHeight();
      let st = $(this).scrollTop();
      // let navbarHeight = $('.header').outerHeight();
      //if (st > lastScrollTop && st >= navbarHeight ){
      if (st >= navbarHeight ){
        // downscroll code
        $('.header').addClass('small');
        
      } else {
        // upscroll code
        $('.header').removeClass('small');
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


    
  },
};
