
@php
	// print_r('<pre>');
	// 	print_r($type);
	// print_r('</pre>');
@endphp

<section class="form section" data-aos="fade-up">

	<div class="form__inner">

		<div class="form__container">

			@php
				$form = $c['form'];

				gravity_form($form, false, true, false, '', true, 1);

			@endphp

			@if($c['footer_message'])
				<div class="form__message">
					{!! $c['footer_message'] !!}
				</div>
			@endif
		</div>

	</div>

</section>