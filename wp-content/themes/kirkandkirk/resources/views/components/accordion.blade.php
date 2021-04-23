<section class="accordion" data-aos="fade-up">

	<div class="accordion__inner">

			<div class="tabs">
				@foreach($c['accordion'] as $section) 

						<div class="tab">
							<input type="checkbox" id="chck{{$loop->iteration}}">
							<label class="tab-label" for="chck{{$loop->iteration}}"><h2>{!! $section['title'] !!}</h2></label>

							<div class="tab-content">
								<div class="list__inner">
									{!! $section['description'] !!}
								</div>
							</div>

						</div>
				@endforeach

			</div>

	</div>

</section>