{{-- @php
	print_r($articles['articles']);
@endphp --}}

<section class="articles">

	<div class="articles__inner">

		<div class="articles__items">

			@if($articles['articles'])

				<div class="articles__sizer"></div>

				@foreach( $articles['articles'] as $article )

					<div class="articles__card" data-aos="fade-up">
						<span class="articles__line" style="border-color: {{ $article['colour'] }};"></span>

						<div class="articles__image {{ $article['border'] }}">
							<img src="{{ $article['image'] }}" alt="{{ $article['title'] }}">
						</div>

						<h3>MEET</h3>
						<h2>{{ $article['title'] }}</h2>

						<div class="articles__text">
							{!! $article['textarea'] !!}
						</div>

					</div>

				@endforeach

			@endif

		</div>

		<div class="articles__more">
			<a href="#" class="btn more-articles">Load More</a>
		</div>

	</div>

</section>