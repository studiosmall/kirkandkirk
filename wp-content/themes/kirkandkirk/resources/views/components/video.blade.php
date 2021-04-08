<section class="video section" data-aos="fade-up">

	<div class="video__inner">

	@php
			// Load value.
			$iframe = $c['vimeo_embed_url'];

			// Use preg_match to find iframe src.
			preg_match('/src="(.+?)"/', $iframe, $matches);
			$src = $matches[1];

			// Add extra parameters to src and replcae HTML.
			$params = array(
					'controls'  => 0,
					'hd'        => 1,
					'autohide'  => 1
			);
			$new_src = add_query_arg($params, $src);
			//$iframe = str_replace($src, $new_src, $iframe);
	@endphp

		<div class="plyr__video-embed" id="player">
			<iframe
				src="{!! $new_src !!}?autoplay=true"
				allowfullscreen
				allowtransparency
				allow="autoplay"
			></iframe>
		</div>

	</div>

</section>