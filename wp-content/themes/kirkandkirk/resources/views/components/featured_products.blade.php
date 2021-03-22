<section class="featured-products">

  <div class="featured-products__inner">

    <div class="featured-products__products">
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

          <a href="{{ $link }}">
            <img src="{{ $image }}"  alt="{{ $title }}">
          </a>

          <div class="featured-products__meta" style="border-color:{{ $colour }};">
            <a href="/"><h1>{{ $title }}</h1></a>
            <a href="/">View</a>
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