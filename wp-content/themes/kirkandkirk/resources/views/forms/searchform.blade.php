<form role="search" method="get" class="header__search search-form" action="{{ home_url('/') }}">
  <label>
    <input
      type="search"
      class="search-field"
      placeholder="{!! esc_attr_x('What are you looking for?', 'placeholder', 'sage') !!}"
      value="{{ get_search_query() }}"
      name="s"
    >
    <input type="submit" id="searchsubmit" class="search-field__submit" value="<?php echo esc_attr_x( '<span class="ico-search"></span>', 'submit button' ); ?>"/>
  </label>
</form>
