
<header class="header">
  <div class="header__banner">
    <div class="header__banner--inner">
      <div class="header__currency">
        Currency (£ GBP)
      </div>

      {{-- <div class="announcement">
          @if($options['message']['banner_message'] == 'enable')
            <span>{!! $options['message']['message'] !!}</span>
          @endif
      </div> --}}

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
      <div class="header__find">
        <a href="/find-a-store">
          Find a Store
        </a>
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
        <a href="#"><span class="ico-search"></span></a>
        <a href="#"><span class="ico-heart"></span></a>
        <a href="#"><span class="ico-account"></span></a>
        <a href="#"><span class="ico-basket"></span></a>
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


  </div>
</div>