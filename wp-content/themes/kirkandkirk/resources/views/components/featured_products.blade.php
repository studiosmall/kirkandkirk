<section class="featured-products">

  <div class="featured-products__inner">

    <div class="featured-products__products slider">
      @foreach($c['products'] as $product)

        <div class="featured-products__product" data-aos="slide-up">
          @php

            $image 		= get_the_post_thumbnail_url($product, 'large');
            $link 		= get_permalink($product);
            $title 		= get_the_title($product);
            $fields  	= get_fields($product);

            $textarea  = $fields['textarea'];
            $colour    = $fields['product_colour'];

          @endphp

          <a class="link" href="{{ $link }}"></a>
          <img src="{{ $image }}"  alt="{{ $title }}">

          <div class="featured-products__meta" style="border-color:{{ $colour }};">
            <h1>{{ $title }}</h1>
            <span>View</span>
          </div>

        </div>
      @endforeach
    </div>

    <div class="featured-products__bottom" data-aos="slide-up">
      <h3>{!! $c['collection_title'] !!}</h3>
      <a href="{{ $c['collection_link'] }}">View Collection</a>
    </div>

  </div>

</section>
{{-- 
<section class="db-links">
  <div class="db-links__inner">
		<div class="links-slider">
			@php($x = 0)
			@foreach($dashboard['page']['links'] as $link)
				<div class="card card--link">
					<img class="card__bg" src="{{ $link['image']['url'] }}" alt="{{ $link['button']['text'] }}">
					<span class="card__btn btn">{{ $link['button']['text'] }}</span>
					@if($x == 0)
						<a class="card__link" href="{{ $dashboard['course_link'] }}"></a>
					@else
						<a class="card__link" href="{{ $link['button']['link'] }}" @if($link['button']['external']) target="_blank" rel="noopener noreferrer" @endif></a>
					@endif
				</div>
				@php($x++)
			@endforeach
		</div>
  </div>
</section> --}}