<li @php post_class('featured-products__product') @endphp>
  {{-- @if (get_post_type() === 'post')
    @include('partials/entry-meta')
  @endif --}}

  @php
    //$product  = wc_get_product($product);
    $currency = get_woocommerce_currency_symbol();
    $price    = get_post_meta( get_the_ID(), '_regular_price', true);
    $sale     = get_post_meta( get_the_ID(), '_sale_price', true);

    $image 		= get_the_post_thumbnail_url($product, 'large');
    $link 		= get_permalink($product);
    $title 		= get_the_title($product);
    $fields  	= get_fields($product);

    $textarea  = $fields['textarea'];
    $colour    = $fields['product_colour'];

  @endphp

  <a class="link" href="{{ get_permalink() }}"></a>
  <div class="image-container">
    <img src="<?php echo $image; ?>"  alt="{!! get_the_title() !!}">
  </div>

  <div class="featured-products__meta" style="border-color:<?php echo $colour; ?>">
    <h1>{!! get_the_title() !!}</h1>
    <?php if($sale) : ?>
      <span><del><?php echo $currency; echo $price; ?></del> <?php echo $currency; echo $sale; ?></span>
    <?php elseif($price) : ?>
      <span><?php echo $currency; echo $price; ?></span>
    <?php endif; ?>
  </div>

</li>
