{{--
The Template for displaying product archives, including the main shop page which is a post type archive

This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.

HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.

@see https://docs.woocommerce.com/document/template-structure/
@package WooCommerce/Templates
@version 3.4.0
--}}

@extends('layouts.app')

@section('content')


  @if(is_product_category('optical'))

    <div class="breadcrumb-container">
      <?php woocommerce_breadcrumb();?>
    </div>

    @include('partials.filter')

    @php
        // Check value exists.
        if( have_rows('content_blocks', 174) ):

            // Loop through rows.
            while ( have_rows('content_blocks', 174) ) : the_row();

                // Case: Paragraph layout.
                if( get_row_layout() == 'collection_products' ):
                    $collection_items = get_sub_field('featured_products');
                    $collection_text  = get_sub_field('collection_title');
                    $collection_link  = get_sub_field('collection_link');

                  @endphp
                    <section class="collection-products">

                      <div class="collection-products__inner">

                        <div class="collection-products__container">

                          <div class="collection-products__bottom" data-aos="fade-up">
                            <div class="collection-products__bottom--inner">
                            <h3>{!! $collection_text !!}</h3>
                            <a class="collection-btn" href="{{ $collection_link }}">View Full Collection</a>
                            </div>
                          </div>

                          <div class="collection-products__products">
                            @foreach($collection_items as $product)

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
                                  <?php if($sale) : ?>
                                  <span><del><?php echo $currency; echo $price; ?></del> <?php echo $currency; echo $sale; ?></span>
                                  <?php elseif($price) : ?>
                                    <span><?php echo $currency; echo $price; ?></span>
                                  <?php endif; ?>
                                </div>

                              </div>
                            @endforeach
                          </div>

                          <div class="collection-btn-mob">
                            <a href="{{ $collection_link }}">View Full Collection</a>
                          </div>

                        </div>

                      </div>

                    </section>

                  @php
                endif;

            // End loop.
            endwhile;

        // No value.
        else :
            // Do something...

        endif;

    @endphp

  @else

    {{-- @php
      do_action('get_header', 'shop');
      do_action('woocommerce_before_main_content');
    @endphp --}}

    <div class="breadcrumb-container">
      <?php woocommerce_breadcrumb();?>
    </div>

    @include('partials.filter')

    <header class="woocommerce-products-header">
      <div class="woocommerce-products-header__inner">
        @if(apply_filters('woocommerce_show_page_title', true))
          <h1 class="woocommerce-products-header__title page-title">{!! woocommerce_page_title(false) !!}</h1>
        @endif

        @php
          do_action('woocommerce_archive_description');
        @endphp
      </div>
    </header>

    @php
      do_action('get_header', 'shop');
      do_action('woocommerce_before_main_content');
    @endphp


    @if(woocommerce_product_loop())
      @php
        do_action('woocommerce_before_shop_loop');
        woocommerce_product_loop_start();
      @endphp

      @if(wc_get_loop_prop('total'))
        @while(have_posts())
          @php
            the_post();
            do_action('woocommerce_shop_loop');
            wc_get_template_part('content', 'product');
          @endphp
        @endwhile
      @endif

      @php
        woocommerce_product_loop_end();
        do_action('woocommerce_after_shop_loop');
      @endphp
    @else
      @php
        do_action('woocommerce_no_products_found');
      @endphp
    @endif


  @endif

  @php
    do_action('woocommerce_after_main_content');
    do_action('get_sidebar', 'shop');
    do_action('get_footer', 'shop');
  @endphp
@endsection
