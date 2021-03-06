<footer class="content-info" @php if($options['colours']['footer_colour']) { @endphp style="background-color: {!! $options['colours']['footer_colour'] !!}" @php } @endphp>
  <div class="content-info__inner">
    {{-- @php dynamic_sidebar('sidebar-footer') @endphp --}}
    <div class="content-info__newsletter">
      <a id="newsletter-popup" href="#">Sign up for our Newsletter</a>
    </div>

    <div class="content-info__row">
      <div class="content-info__row--col">
        <p>@if($options['details']['address']){!! $options['details']['address'] !!}@endif</p>
      </div>

      <div class="content-info__row--col">
        @if (has_nav_menu('footer_left_navigation'))
          {!! wp_nav_menu(
            ['theme_location' => 'footer_left_navigation',
            'menu_class' => 'nav',
            'items_wrap' => '<ul>%3$s</ul>',
            ]) !!}
        @endif
      </div>

      <div class="content-info__row--col">
        @if (has_nav_menu('footer_center_navigation'))
          {!! wp_nav_menu(
            ['theme_location' => 'footer_center_navigation',
            'menu_class' => 'nav',
            'items_wrap' => '<ul>%3$s</ul>',
            ]) !!}
        @endif
      </div>

      <div class="content-info__row--col">
        @if (has_nav_menu('footer_right_navigation'))
          {!! wp_nav_menu(
            ['theme_location' => 'footer_right_navigation',
            'menu_class' => 'nav',
            'items_wrap' => '<ul>%3$s</ul>',
            ]) !!}
        @endif
      </div>
    </div>

    <div class="content-info__bottom">
      <div class="content-info__row-bottom--col">

        <div class="content-info__mark">
          <svg width="89px" height="85px" viewBox="0 0 89 85" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <defs>
                  <polygon id="path-1" points="0.136906032 0.216445623 70.86936 0.216445623 70.86936 84.9993011 0.136906032 84.9993011"></polygon>
                  <polygon id="path-3" points="0.000158204334 0.216445623 72.9680653 0.216445623 72.9680653 84.999256 0.000158204334 84.999256"></polygon>
                  <polygon id="path-5" points="0.206878667 0.217142857 16.815652 0.217142857 16.815652 18.7812512 0.206878667 18.7812512"></polygon>
              </defs>
              <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <g id="FOOTER" transform="translate(-21.000000, -310.000000)">
                      <g id="Group-12" transform="translate(21.000000, 310.000000)">
                          <g id="Group-3" transform="translate(18.000000, 0.000000)">
                              <mask id="mask-2" fill="white">
                                  <use xlink:href="#path-1"></use>
                              </mask>
                              <g id="Clip-2"></g>
                              <path d="M66.5421917,0.216423077 L45.2072552,0.216423077 C45.2072552,0.216423077 50.8090425,3.08139655 50.8090425,11.8717944 L50.8090425,42.0082401 L27.3012806,4.11447347 C25.786614,1.67179443 23.1167886,0.216423077 20.2432044,0.216423077 L1.79289651,0.216423077 L0.136906032,0.216423077 C0.172067937,0.216423077 0.208356825,0.218903183 0.246223492,0.224314324 C0.294458413,0.230852785 0.344947302,0.241675066 0.397464762,0.256555703 C0.511740952,0.288797082 0.635934603,0.340428382 0.769144127,0.409645889 C4.55874095,2.3815557 15.704614,18.7759589 15.704614,18.7759589 L39.5971283,57.2311313 L43.6901092,50.631118 L50.8090425,62.1106273 L50.8090425,70.9389032 C50.8090425,78.7041154 57.1023473,84.9993011 64.8654648,84.9993011 L66.5421917,84.9993011 C68.9320743,84.9993011 70.86936,83.0612109 70.86936,80.6706141 L70.86936,4.58028249 C70.86936,2.18968568 68.9320743,0.216423077 66.5421917,0.216423077" id="Fill-1" fill="#000000" mask="url(#mask-2)"></path>
                          </g>
                          <g id="Group-6">
                              <mask id="mask-4" fill="white">
                                  <use xlink:href="#path-3"></use>
                              </mask>
                              <g id="Clip-5"></g>
                              <path d="M60.6737805,70.9388581 L31.3558053,23.9302507 L20.1147093,42.0084204 L20.1147093,11.7204629 C20.1147093,5.36688196 14.9515978,0.216377984 8.58296935,0.216377984 L4.33902508,0.216377984 C1.94268142,0.216377984 0.000158204334,2.15424271 0.000158204334,4.54506499 L0.000158204334,80.670569 C0.000158204334,83.0613912 1.94268142,84.999256 4.33902508,84.999256 L6.02028514,84.999256 C13.8043904,84.999256 20.1147093,78.7040703 20.1147093,70.9388581 L20.1147093,62.1105822 L27.2528889,50.6310729 L46.1806814,81.0707679 C47.699669,83.5132215 50.3764864,84.999256 53.2578393,84.999256 L72.9680653,84.999256 C72.9361985,84.999256 72.9038796,84.9983541 72.8715607,84.9965504 C72.8631985,84.9960995 72.8546102,84.9956485 72.846474,84.9949721 C72.7940406,84.9913647 72.7411551,84.9852772 72.6871396,84.9771605 C72.5739105,84.9597997 72.4577433,84.9320676 72.3384121,84.895317 C68.2004647,83.6155822 60.6737805,70.9388581 60.6737805,70.9388581" id="Fill-4" fill="#000000" mask="url(#mask-4)"></path>
                          </g>
                          <path d="M27.4516785,71.2439347 C27.4516785,71.2439347 19.6792218,83.889281 15.5161495,84.9318483 C15.4378688,84.9512572 15.3607325,84.9669166 15.2849695,84.978165 C15.2403357,84.9847816 15.1963886,84.9898544 15.1526704,84.9936039 C15.1011699,84.9977944 15.0501272,85 15,85 L15.2799339,85 L15.4440488,85 L34.9615972,85 C37.8021363,85 40.4412513,83.6215262 42,81.3453904 L31.4801628,65 L27.4516785,71.2439347 Z" id="Fill-7" fill="#000000"></path>
                          <g id="Group-11" transform="translate(48.000000, 0.000000)">
                              <mask id="mask-6" fill="white">
                                  <use xlink:href="#path-5"></use>
                              </mask>
                              <g id="Clip-10"></g>
                              <path d="M0.690132,2.56859643 L0.690812,2.56904881 L10.769092,18.7812512 L16.815652,9.05890595 C15.597772,3.98748929 11.0272653,0.217120238 5.57162533,0.217120238 L5.15795867,0.217120238 C3.35867867,0.217120238 1.634652,0.781691667 0.206878667,1.79050119 L0.690812,2.56882262 L0.690132,2.56859643 Z" id="Fill-9" fill="#000000" mask="url(#mask-6)"></path>
                          </g>
                      </g>
                  </g>
              </g>
          </svg>
        </div>

      </div>

      <div class="content-info__row-bottom--col">
        @if($options['details']['footer_details'])
          {!! $options['details']['footer_details'] !!}
        @endif
      </div>

      <div class="content-info__row-bottom--col">
        <div class="content-info__copyright">
          <span class="content-info__by">site by: <a href="https://studiosmall.com" target="_blank" rel="nofollow noopener noreferrer">StudioSmall</a></span>
          <span>copyright {!! get_bloginfo('name', 'display') !!} {!! date('Y') !!}</span>
        </div>

      </div>

    </div>

  </div>
</footer>

@include('partials.newsletter')