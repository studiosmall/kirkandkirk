<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

if ( $product->is_in_stock() ) : ?>


<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>


<?php
	$featured_posts = get_field('product_variations');
	$current        = get_the_ID();
	$current_colour = get_field('product_colour', $current);
?>

	<?php if($featured_posts) { ?>
		<ul class="colours">
			<li>
				<a href="#">
					<span class="product-col active" style="background-color: <?php echo $current_colour ?>"></span>
				</a>
			</li>
			<?php foreach( $featured_posts as $featured_post ):
					$permalink = get_permalink( $featured_post->ID );
					// $title = get_the_title( $featured_post->ID );
					$colour = get_field('product_colour', $featured_post->ID);
					?>
					<li>
							<a href="<?php echo esc_url( $permalink ); ?>">
								<span class="product-col" style="background-color: <?php echo $colour ?>"></span>
							</a>
					</li>
			<?php endforeach; ?>
		</ul>
	<?php } ?>

	<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>

	<?php
		$eye_size = get_field('eye_size');
		$bridge   = get_field('bridge');
	?>

	<div class="eye-size">
		<?php if($eye_size) { ?><span>Eye size:</span> 	<?php echo $eye_size; } ?><?php if($bridge) { ?>, <span>Bridge:</span> <?php echo $bridge; } ?>
	</div>

	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<?php
		do_action( 'woocommerce_before_add_to_cart_quantity' );

		woocommerce_quantity_input(
			array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
				'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
			)
		);

		?>


		<?php if (!current_user_can('optician')) { ?>
			<div class="how-to__container">
				<a class="how-to" href="/faqs">FAQs</a>
			</div>

			<?php
				$url_ID = get_the_ID();
			?>
			<div class="share">
				<a id="share-icons" href="#">Share</a>
					<div class="share__inner">
						<ul>
							<li>
								<a href="https://www.facebook.com/sharer.php?u=<?php the_permalink($url_ID); ?>" target="_blank">
									Facebook
								</a>
							</li>
							<!-- <li>
								<a href="//pinterest.com/pin/create/link/?url=<?php// the_permalink($url_ID); ?>&amp;description=<?php// the_title(); ?>" target="_blank">Pinterest</a>
							</li> -->

							<a href="https://www.pinterest.com/pin/create/button/" data-pin-do="buttonBookmark" data-pin-custom="true">Pinterest</a>
							<li>
								<a href="https://twitter.com/intent/tweet
	?url=http%3A%2F%2F<?php the_permalink($url_ID); ?>%2F
	&text=<?php the_title($url_ID); ?>" target="_blank">
									Twitter
								</a>
							</li>
						</ul>
					</div>
			</div>

		<?php } ?>

		<?php do_action( 'woocommerce_after_add_to_cart_quantity' ); ?>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

		<?php

    if (current_user_can('optician')) {
        ?>
        <div class="quantity row">
            <label>Quantity</label>
            <input type="number" id="optician-quantity" class="qty optician-qty" name="quantity" min="1" max="999" value="1" />
        </div>

        <button type="button" value="<?php echo esc_attr( $product->get_id() ); ?>" class="optician_single_add_to_cart_button button alt"><?php echo esc_html($product->single_add_to_cart_text()); ?></button>

        <?php

    } else {


		
			// $nosepads   = get_field('nosepad_product_link');
			// $nosepadsID = $nosepads[0]->ID;
			// $nosepadsLink = get_permalink($nosepadsID);
		

	  if($nosepads) { ?>
			<!-- <div class="nosepads-container">
				<a href="<?php //echo $nosepadsLink; ?>">Add Nosepads</a>
			</div> -->
		<?php } ?>

		<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

		<!-- <?php //if ( $product->is_in_stock() ) : ?>
			<button type="submit" name="add-to-cart" value="<?php //echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt"><?php //echo esc_html( $product->single_add_to_cart_text() ); ?></button>
		<?php //else : ?>
			<button disabled type="submit" name="add-to-cart" value="<?php //echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt out-of-stock">Out of Stock</button>
		<?php// endif; ?> -->


		<?php } ?>

	</form>

  <?php echo wc_get_stock_html($product ); // WPCS: XSS ok. ?>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>




