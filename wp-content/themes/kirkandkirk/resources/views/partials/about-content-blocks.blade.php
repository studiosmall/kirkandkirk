@isset($about_content_blocks)
	@foreach ($about_content_blocks as $c)
		@isset($c['acf_fc_layout'])
			@include('components.' . $c['acf_fc_layout'], $c)
		@endisset
	@endforeach
@endisset