<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
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

defined('ABSPATH') || exit;

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
    do_action('woocommerce_before_cart'); ?>

    <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
        <?php do_action('woocommerce_before_cart_table'); ?>

        <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
            <thead>
                <tr>
                    <th class="product-remove">&nbsp;</th>
                    <th class="product-thumbnail">&nbsp;</th>
                    <th class="product-name"><?php esc_html_e('Product', 'woocommerce'); ?></th>
                    <th class="product-price"><?php esc_html_e('Price', 'woocommerce'); ?></th>
                    <th class="product-quantity"><?php esc_html_e('Quantity', 'woocommerce'); ?></th>
                    <th class="product-subtotal"><?php esc_html_e('Total', 'woocommerce'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php do_action('woocommerce_before_cart_contents'); ?>

                <?php
                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                    $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                    if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                        $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                        ?>
                        <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

                            <td class="product-remove">
                                <?php
									// @codingStandardsIgnoreLine
									echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                                        '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                        esc_url(wc_get_cart_remove_url($cart_item_key)),
                                        __('Remove this item', 'woocommerce'),
                                        esc_attr($product_id),
                                        esc_attr($_product->get_sku())
                                    ), $cart_item_key );
                                ?>
                            </td>

                            <td class="product-thumbnail">
                            <?php
                            $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

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
                                echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                            } else {
                                echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                            }

                            do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

                            // Meta data.
                            echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

                            // Backorder notification.
                            if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                            }
                            ?>
                            </td>

                            <td class="product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                                <?php
                                    echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                                ?>
                            </td>

                            <td class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                            <?php
                            if ($_product->is_sold_individually()) {
                                $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                            } else {
                                $product_quantity = woocommerce_quantity_input(array(
                                    'input_name'   => "cart[{$cart_item_key}][qty]",
                                    'input_value'  => $cart_item['quantity'],
                                    'max_value'    => $_product->get_max_purchase_quantity(),
                                    'min_value'    => '0',
                                    'product_name' => $_product->get_name(),
                                ), $_product, false);
                            }

                            echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
                            ?>
                            </td>

                            <td class="product-subtotal" data-title="<?php esc_attr_e('Total', 'woocommerce'); ?>">
                                <?php
                                    echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>

                <?php do_action('woocommerce_cart_contents'); ?>

                <tr>
                    <td colspan="6" class="actions">

                        <?php if (wc_coupons_enabled()) { ?>
                            <div class="coupon">
                                <label for="coupon_code"><?php esc_html_e('Coupon:', 'woocommerce'); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" /> <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_attr_e('Apply coupon', 'woocommerce'); ?></button>
                                <?php do_action('woocommerce_cart_coupon'); ?>
                            </div>
                        <?php } ?>

                        <button type="submit" class="button" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"><?php esc_html_e('Update cart', 'woocommerce'); ?></button>

                        <?php do_action('woocommerce_cart_actions'); ?>

                        <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                    </td>
                </tr>

                <?php do_action('woocommerce_after_cart_contents'); ?>
            </tbody>
        </table>
        <?php do_action('woocommerce_after_cart_table'); ?>
    </form>

    <div class="cart-collaterals">
        <?php
            /**
             * Cart collaterals hook.
             *
             * @hooked woocommerce_cross_sell_display
             * @hooked woocommerce_cart_totals - 10
             */
            do_action('woocommerce_cart_collaterals');
        ?>
    </div>

    <?php do_action('woocommerce_after_cart');
}
?>