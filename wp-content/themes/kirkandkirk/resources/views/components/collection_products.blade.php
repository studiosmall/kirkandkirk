<section class="collection-products">

  <div class="collection-products__inner">

    <div class="collection-products__container">

      <div class="collection-products__bottom" data-aos="fade-up">
        <div class="collection-products__bottom--inner">
        <h3>{!! $c['collection_title'] !!}</h3>
        <a class="collection-btn" href="{{ $c['collection_link'] }}">View Full Collection</a>
        </div>
      </div>

      <div class="collection-products__products">
        @foreach($c['products'] as $product)

          <div class="collection-products__product">
            @php

              $image 		= get_the_post_thumbnail_url($product, 'large');
              $link 		= get_permalink($product);
              $title 		= get_the_title($product);
              $fields  	= get_fields($product);

              $textarea  = $fields['textarea'];
              $colour    = $fields['product_colour'];

              $currency = get_woocommerce_currency_symbol();
						  $price    = get_post_meta( $product, '_regular_price', true);
						  $sale     = get_post_meta( $product, '_sale_price', true);

            @endphp

            <a class="link" href="{{ $link }}"></a>
            <img src="{{ $image }}"  alt="{{ $title }}">

            <div class="collection-products__meta" style="border-color:{{ $colour }};">
              <h1>{{ $title }}</h1>
              <?php if (!current_user_can('optician')) { ?>
                <?php if($sale) : ?>
                <span><del><?php echo $currency; echo $price; ?></del> <?php echo $currency; echo $sale; ?></span>
                <?php elseif($price) : ?>
                  <span><?php echo $currency; echo $price; ?></span>
                <?php endif; ?>
              <?php } ?>
            </div>

          </div>
        @endforeach
      </div>

      <div class="collection-btn-mob">
        <a href="{{ $c['collection_link'] }}">View Full Collection</a>
      </div>

    </div>

  </div>

</section>