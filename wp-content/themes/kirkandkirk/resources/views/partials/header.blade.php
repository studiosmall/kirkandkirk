@php
  $hex             = $options['colours']['header_colour'];
  list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
  $headerColour    = "$r, $g, $b, 0.80";
@endphp

<header class="header" @php if($options['colours']['footer_colour']) { @endphp style="background-color: rgba({!! $headerColour !!})" @php } @endphp>
  <div class="header__banner" @php if($options['colours']['footer_colour']) { @endphp style="background-color: rgba({!! $options['colours']['banner_colour'] !!})" @php } @endphp>
    <div class="header__banner--inner">
      <div class="header__currency">
        <span>Currency:</span>

        @php
          echo do_shortcode('[wcpbc_currency_switcher currency_display_style="{symbol} {code}" remove_other_countries="1"]');
        @endphp
      </div>

      {{-- <div class="announcement">
          @if($options['message']['banner_message'] == 'enable')
            <span>{!! $options['message']['message'] !!}</span>
          @endif
      </div> --}}

      @php
        $user = wp_get_current_user();
      @endphp

      @if ( in_array( 'optician', (array) $user->roles ) )
        <span class="professional">PROFESSIONAL ACCOUNT</span>
      @else
        <div class="announcement">
          <div class="announcement__item">
            @if($options['message']['banner_message'] == 'enable')
              <span>{!! $options['message']['message'] !!}</span>
            @endif
          </div>

          <div class="announcement__item">
            @if($options['message']['banner_message'] == 'enable')
              <span>{!! $options['message']['secondary_message'] !!}</span>
            @endif
          </div>
        </div>
      @endif

      <div class="header__find">
        <?php if (!current_user_can('optician')) : ?>
        <a href="/retailers">
          Find a Store
        </a>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="header__inner">
    <div class="header__logo-container">
      <a href="{{ home_url('/') }}">
        <img class="header__logo" src="@asset('images/logo.svg')" alt="{{ get_bloginfo('name', 'display') }}">
      </a>
    </div>

  	<div class="header__left">
       <div class="header__menu-container">
        <button class="header__hamburger">
          <span class="lines"></span>
        </button>
      </div>
	  </div>

    <div class="header__right">
	    <div class="header__buttons">
        <div class="header__search-container">
          <a id="search-btn" href="#">
            <span class="ico-search"></span>
          </a>
          {{-- {!! get_search_form(false) !!} --}}

          <form role="search" method="get" class="header__search search-form" action="{{ home_url('/') }}">
            <label>
              <input
                type="search"
                class="search-field"
                placeholder="{!! esc_attr_x('Search...', 'placeholder', 'sage') !!}"
                value="{{ get_search_query() }}"
                name="s"
              >
              <input type="submit" id="searchsubmit" class="search-field__submit" value=""/>
            </label>
          </form>

        </div>
        @if (!in_array( 'optician', (array) $user->roles ) )
          <a href="/wishlists"><span class="ico-heart"></span></a>
        @endif

        <a href="/account"><span class="ico-account"></span></a>

        @if (current_user_can('optician'))
          @php if ( dynamic_sidebar('hb_common_right_widget') ) : else : endif; @endphp
          <span class="spacer">|</span> <a class="logout" href="/account/customer-logout/?_wpnonce=624d7b2cde">Logout</a>
        @else
          <a class="cart-customlocation" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><span class="ico-basket"></span><span><?php echo sprintf ( _n('(%d)', '(%d)', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?></span></a>
        @endif


	    </div>
	  </div>
  </div>
</header>

<div class="off-canvas">
	<div class="off-canvas__inner">
    @if (has_nav_menu('left_navigation'))
      {!! wp_nav_menu(
        ['theme_location' => 'left_navigation',
        'menu_class' => 'nav',
        'items_wrap' => '<ul>%3$s</ul>',
        ]) !!}
    @endif

    @php $user = wp_get_current_user(); @endphp

    @if ( in_array( 'optician', (array) $user->roles ) )

    @if (has_nav_menu('professional_centre_navigation'))
      {!! wp_nav_menu(
        ['theme_location' => 'professional_centre_navigation',
        'menu_class' => 'nav',
        'items_wrap' => '<ul>%3$s</ul>',
        ]) !!}
      @endif

      @if (has_nav_menu('professional_right_navigation'))
      {!! wp_nav_menu(
        ['theme_location' => 'professional_right_navigation',
        'menu_class' => 'nav',
        'items_wrap' => '<ul>%3$s</ul>',
        ]) !!}
      @endif

    @else

      @if (has_nav_menu('center_navigation'))
      {!! wp_nav_menu(
        ['theme_location' => 'center_navigation',
        'menu_class' => 'nav',
        'items_wrap' => '<ul>%3$s</ul>',
        ]) !!}
      @endif

      @if (has_nav_menu('right_navigation'))
      {!! wp_nav_menu(
        ['theme_location' => 'right_navigation',
        'menu_class' => 'nav',
        'items_wrap' => '<ul>%3$s</ul>',
        ]) !!}
      @endif

    @endif

  </div>
</div>