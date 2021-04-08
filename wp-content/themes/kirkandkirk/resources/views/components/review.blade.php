<section class="featured-products">

  <div class="featured-products__inner">

    <div class="featured-products__products slider">
      @foreach($c['products'] as $product)

        <div class="featured-products__product">
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

    <div class="featured-products__bottom" data-aos="fade-up">
      <div class="featured-products__bottom--inner">
      <h3>{!! $c['collection_title'] !!}</h3>

      <a href="{{ $c['collection_link'] }}">View Collection</a>
      </div>
    </div>

  </div>

</section>