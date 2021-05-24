<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

//if (current_user_can('optician')) {
$user = wp_get_current_user();
if ( in_array( 'optician', (array) $user->roles ) ) {
    do_action('woocommerce_before_cart');
    $user_id = get_current_user_id();
    $optician_cart_data = get_user_meta($user_id, 'optician_cart_data', true);
    $optician_cart_data_array = unserialize($optician_cart_data);
    /*$optician_cart_data_array = array_values( array_filter( $optician_cart_data_array ) );*/
    if (!empty($optician_cart_data_array[0])) {
        /*echo "zz=><pre>";
        print_r($optician_cart_data_array);
        echo "</pre>";*/
        ?>
        <form class="woocommerce-otician-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
        <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
            <thead>
                <tr>
                    <th class="product-remove">&nbsp;</th>
                    <th class="product-thumbnail">&nbsp;</th>
                    <th class="product-name"><?php esc_html_e('Product', 'woocommerce'); ?></th>
                    <!-- <th class="product-subtotal"><__?php esc_html_e('Frames/Temples', 'woocommerce'); ?></th> -->
                    <th class="product-quantity"><?php esc_html_e('Quantity', 'woocommerce'); ?></th>
                    <th class="product-subtotal"><?php esc_html_e('Reference', 'woocommerce'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($optician_cart_data_array as $cart_item_key => $cart_item) {
                    $product_id = $cart_item['product_id'];
                    $variation_id = $cart_item['variation_id'];
                    $variation_title = get_the_title($variation_id);
                    $variation_title = $variation_title ? $variation_title : '';
                    $attachment_id = get_post_meta($variation_id, '_thumbnail_id', true);
                    $_product = wc_get_product($product_id);

                    if ($_product && $_product->exists()) {
                        $product_permalink = get_permalink($variation_id);
                        ?>
                        <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

                            <td class="product-remove">
                                <a href="javascript:void(0)" class="optician_remove_item" id="optician_remove_item-<?php echo $variation_id; ?>" aria-label="<?php _e('Remove this item', 'woocommerce'); ?>" data-product_id="<?php echo esc_attr($product_id); ?>" data-variation_id="<?php echo esc_attr($variation_id); ?>" data-variation_title="<?php echo esc_attr($variation_title); ?>">&times;</a>
                            </td>

                            <td class="product-thumbnail">
                            <?php
                            $thumbnail = wp_get_attachment_image($attachment_id, 'full', "", array( "class" => "attachment-woocommerce_thumbnail size-woocommerce_thumbnail" ));

                            if (! $product_permalink) {
                                echo $thumbnail; // PHPCS: XSS ok.
                            } else {
                                printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
                            }
                            ?>
                            </td>

                            <td class="product-name" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                            <?php
                            if (! $product_permalink) {
                                echo wp_kses_post($variation_title);
                            } else {
                                echo wp_kses_post(sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $variation_title));
                            }
                            ?>
                            </td>
                            <!-- 
                            <td class="product-subtotal" data-title="<__?php esc_attr_e('Temples', 'woocommerce'); ?>">
                                <__?php
                                    $temples_arr = array();
                                if (isset($cart_item['optician_left'])) {
                                    array_push($temples_arr, $cart_item['optician_left']);
                                }
                                if (isset($cart_item['optician_right'])) {
                                    array_push($temples_arr, $cart_item['optician_right']);
                                }
                                    $temples = implode(", ", $temples_arr);
                                if (!isset($cart_item['optician_left']) && !isset($cart_item['optician_right'])) {
                                    $temples = __('Frame(s)', 'woocommerce');
                                }

                                    echo $temples;
                                __?>
                            </td> -->

                            <td class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                                <?php
                                    echo $cart_item['quantity'];
                                ?>
                            </td>

                            <td class="product-subtotal" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                                <textarea cols="20" rows="3" class="input-text" name="reference" id="reference" placeholder="" maxlength="100"></textarea>
                            </td>

                        </tr>
                        <?php
                    }
                }
                ?>
                
                <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                
            </tbody>
        </table>
        <div class="name_of_store">
            <span class="msg">Name of Store</span>
            <input type="text" class="input-text" name="name_of_store" id="js_name_of_store" placeholder="Name Of Store">
        </div>
        <div class="profession-order-note">
            <span class="msg">Do you need to order a spare part?</span>
            <span class="msg">Please tell us how we can help you.</span>
            <textarea cols="20" rows="3" class="input-text" name="ordernote" id="js_ordernote" placeholder="Order note" maxlength="100"></textarea>
        </div>
        <div class="cart-collaterals">
            <div class="cart_totals">
                <div class="wc-proceed-to-checkout">
                    <button type="button" class="optician-checkout-button button alt wc-forward"><?php esc_html_e('Send', 'woocommerce'); ?></button>
                </div>
            </div>
        </div>
        </form>
        <?php
    } else {
        ?>
        <p class="cart-empty woocommerce-info"><?php _e('Your cart is currently empty.', 'woocommerce'); ?></p>
        <p class="return-to-shop">
            <a class="button wc-backward" href="<?php echo get_permalink(wc_get_page_id('shop')); ?>"><?php _e('Return to shop', 'woocommerce'); ?></a>
        </p>
    <?php }
} else {
/*
 * @hooked wc_empty_cart_message - 10
 */
do_action( 'woocommerce_cart_is_empty' );

if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
	<p class="return-to-shop">
		<a class="button wc-backward" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			<?php esc_html_e( 'Return to shop', 'woocommerce' ); ?>
		</a>
	</p>
<?php endif;
}
?>