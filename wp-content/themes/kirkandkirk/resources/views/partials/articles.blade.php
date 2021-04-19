{{-- @php
	print_r($articles['articles']);
@endphp --}}

<section class="articles">

	<div class="articles__inner">

		<div class="articles__items" data-offset="6">

			@if($articles['articles'])

				<div class="articles__sizer"></div>

				@foreach( $articles['articles'] as $article )

					{{-- <div class="articles__card" data-aos="fade-up"> --}}
					<div class="articles__card">
						<span class="articles__line" style="border-color: {{ $article['colour'] }};"></span>

						<div class="articles__image {{ $article['border'] }}">
							<img src="{{ $article['image'] }}" alt="{{ $article['title'] }}">
						</div>

						<h3>MEET</h3>
						<h2>{{ $article['title'] }}</h2>

						<div class="articles__text">

							<p>
								{!! $article['textarea'] !!}

								@if($article['readmore'])
									<span class="moretext">{!! $article['readmore'] !!}</span>

									<a class="moreless-button" href="#">Read More</a>
								@endif
							</p>

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