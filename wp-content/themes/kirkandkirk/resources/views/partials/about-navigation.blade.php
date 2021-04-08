<section class="about-nav">
	<div class="about-nav__inner">
		@if (has_nav_menu('about_navigation'))
		{!! wp_nav_menu(
			['theme_location' => 'about_navigation',
			'menu_class' => 'nav',
			'items_wrap' => '<ul>%3$s</ul>',
			]) !!}
		@endif
	</div>
</section>