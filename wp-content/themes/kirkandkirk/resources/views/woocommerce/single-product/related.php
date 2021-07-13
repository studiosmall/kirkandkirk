<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
//  * @see         https://docs.woocommerce.com/document/template-structure/
//  * @package     WooCommerce\Templates
//  * @version     3.9.0
//  */

// if ( ! defined( 'ABSPATH' ) ) {
// 	exit;
// }

// // print_r('<pre>');
// // 	print_r($related_products);
// // print_r('</pre>');

// if ( $related_products ) : 

// 	<section class="featured-products related">
// 		<div class="featured-products__inner">
// 	
// 		$heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'SIMILAR STYLES', 'woocommerce' ) );


// 	
// 			<div class="title__inner">
// 				<h2><?php echo esc_html( $heading ); </h2>
// 			</div>

// 	 woocommerce_product_loop_start(); 

// 			<div class="featured-products__products slider">
			
// 			<?php foreach ( $related_products as $related_product ) :
// 					

// 						$post_object = get_post( $related_product->get_id() );

// 						setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

// 						wc_get_template_part( 'content', 'product' );
// 					

// 			endforeach; 
// 			</div>
// 	woocommerce_product_loop_end();
// 		</div>

// 	</section>
// 	<?php
// endif;

// wp_reset_postdata();



/**
 * Related Products
 *
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( is_singular('product') ) {
global $post;

// get categories
$terms = wp_get_post_terms( $post->ID, 'product_cat' );
foreach ( $terms as $term ) $cats_array[] = $term->term_id;

$query_args = array( 
	'orderby' => 'rand', 
	'post__not_in' => array( $post->ID ), 
	'posts_per_page' => 99, 
	//'no_found_rows' => 1, 
	'post_status' => 'publish', 
	'post_type' => 'product', 
	'tax_query' => array(
		array(
			'taxonomy' => 'product_cat',
			'field' => 'id',
			'terms' => $cats_array,
		),
		array(
			'taxonomy'    => 'product_cat',
			'field'       => 'id',
			'terms'       => array(61,49),
			'operator'    => 'NOT IN'
		)
	)
);

$r = new WP_Query($query_args);
if ($r->have_posts()) { 
	
	// print_r('<pre>');
	// print_r($r);
	// print_r('</pre>');

	//print_r($cats_array);	
	// $test = get_the_category_by_ID(22);
	// echo $test;
	
	?>

<section class="featured-products related">
		<div class="featured-products__inner">
  

			<div class="title__inner">
				<h2>SIMILAR STYLES</h2>
			</div>

        <?php //woocommerce_product_loop_start(); ?>
					<div class="featured-products__products slider related-slider">
            <?php while ($r->have_posts()) : $r->the_post(); global $product; ?>

                <?php wc_get_template_part( 'content', 'product' ); ?>

            <?php endwhile; // end of the loop. ?>
					</div>
        <?php //woocommerce_product_loop_end(); ?>

    </div>
</section>
<?php

wp_reset_query();
}
}
