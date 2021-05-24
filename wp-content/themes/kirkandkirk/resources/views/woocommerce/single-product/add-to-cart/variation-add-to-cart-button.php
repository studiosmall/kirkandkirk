<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
?>

<div class="woocommerce-variation-add-to-cart variations_button">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<div class="how-to__container">
		<a class="how-to" href="/faqs">FAQs</a>
	</div>

	<div class="share">
		<a href="#">Share</a>
	</div>

	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<?php
	do_action( 'woocommerce_before_add_to_cart_quantity' );

	woocommerce_quantity_input(
		array(
			'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
			'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
			'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
		)
	);

	do_action( 'woocommerce_after_add_to_cart_quantity' );
	
	?>

<?php if (current_user_can('optician')) {
        ?>
        <div class="quantity row">
            <label>Quantity</label>
            <input type="number" id="optician-quantity" class="qty optician-qty" name="quantity" min="1" max="999" value="1" />
        </div>
        <!-- <div class="temples row">
            <label>Temples</label>
            <p>
                <input type="checkbox" id="optician-left" class="input-checkbox" name="optician_left" value="Left" /> Left
            </p>
            <p>
                <input type="checkbox" id="optician-right" class="input-checkbox" name="optician_right" value="Right" /> Right
            </p>
        </div> -->

            <button type="button" value="<?php echo esc_attr( $product->get_id() ); ?>" class="optician_variable_add_to_cart_button button alt"><?php echo esc_html($product->single_add_to_cart_text()); ?></button>

        <?php
		echo 'Yes Opt';

    } else { ?>


	<button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
	<?php } ?>

	<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>
