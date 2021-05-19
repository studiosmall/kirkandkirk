<section class="collaborations">

  <div class="collaborations__inner">

    <div class="collaborations__items">

			@if($c['collaborations'])

				@foreach( $c['collaborations'] as $colab )

					<div class="collaborations__card" data-aos="fade-up">
						<span class="collaborations__line" style="border-color: {{ $colab['colour'] }};"></span>

						<div class="collaborations__card--inner">
							<div class="collaborations__image border">
								<a href="{{ $colab['link_url'] }}">
                  <div class="bg-image" style="background-image: url('{{ $colab['image']['url'] }}');">

                  </div>
									{{-- <img src="{{ $colab['image']['url'] }}" alt="{{ $colab['title'] }}"> --}}
								</a>
							</div>

							<h3>MEET</h3>
							<a href="{{ $colab['link_url'] }}">
								<h2>{{ $colab['title'] }}</h2>
							</a>

							<div class="collaborations__text">

								<p>
									{!! $colab['textarea'] !!}
								</p>

									@if($colab['link_url'])
										{{-- <span class="moretext">{!! $colab['readmore'] !!}</span> --}}

										{{-- <a class="moreless-button" href="#">Read More</a> --}}
										<a class="more" href="{{ $colab['link_url'] }}">Read More</a>
									@endif


							</div>
						</div>
					</div>

				@endforeach

			@endif

		</div>

  </div>

</section>