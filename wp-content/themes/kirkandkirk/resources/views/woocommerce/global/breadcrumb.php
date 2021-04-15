<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $breadcrumb ) ) {

	echo $wrap_before;

	foreach ( $breadcrumb as $key => $crumb ) {

		echo $before;

		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
		} else {
			echo esc_html( $crumb[0] );
		}

		echo $after;

		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
			echo $delimiter;
		}
	}

	echo $wrap_after;


	// $terms = get_terms([
  //   'taxonomy' => 'pa_colour',
  //   'hide_empty' => false,
	// ]);

	// foreach ($terms as $term) {
  //   echo get_term_meta($term->term_id)["colour"][0]; // Ex: #d4be16

	// 	print('<pre>');
	// 		print_r($term);
	// 	print_r('</pre>');

	// }

	// $brand_terms = get_the_terms(305, 'pa_colour');
	// $brand_string = ''; // Reset string
	// foreach ($brand_terms as $term) :
	// 		$brand_string .= $term->slug . ' ';
	// endforeach;

  // global $product;
  // //$size = $product->get_attribute('pa_colour');

	// print_r($product);


	//echo $product->get_attribute( 'pa_colour' );

// 	global $product;

// if ( get_post_type( $post ) === 'product' && ! is_a($product, 'WC_Product') ) {
//     $product = wc_get_product( get_the_id() ); // Get the WC_Product Object
// }

// $product_attributes = $product->get_attributes(); // Get the product attributes

// // Raw output
// echo '<pre>'; print_r( $product_attributes ); echo '</pre>';

// $product = wc_get_product(305);
// $variations = $product->get_available_variations();
// $variations_id = wp_list_pluck( $variations, 'variation_id' );

// 	print_r('<pre>');
// 	print_r($variations);
// 	print_r('</pre>');

}