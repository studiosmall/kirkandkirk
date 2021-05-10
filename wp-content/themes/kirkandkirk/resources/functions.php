<?php

/**
 * Do not edit anything in this file unless you know what you're doing
 */

use Roots\Sage\Config;
use Roots\Sage\Container;

/**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$sage_error = function ($message, $subtitle = '', $title = '') {
    $title = $title ?: __('Sage &rsaquo; Error', 'sage');
    $footer = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};

/**
 * Ensure compatible version of PHP is used
 */
if (version_compare('7.1', phpversion(), '>=')) {
    $sage_error(__('You must be using PHP 7.1 or greater.', 'sage'), __('Invalid PHP version', 'sage'));
}

/**
 * Ensure compatible version of WordPress is used
 */
if (version_compare('4.7.0', get_bloginfo('version'), '>=')) {
    $sage_error(__('You must be using WordPress 4.7.0 or greater.', 'sage'), __('Invalid WordPress version', 'sage'));
}

/**
 * Ensure dependencies are loaded
 */
if (!class_exists('Roots\\Sage\\Container')) {
    if (!file_exists($composer = __DIR__.'/../vendor/autoload.php')) {
        $sage_error(
            __('You must run <code>composer install</code> from the Sage directory.', 'sage'),
            __('Autoloader not found.', 'sage')
        );
    }
    require_once $composer;
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(function ($file) use ($sage_error) {
    $file = "../app/{$file}.php";
    if (!locate_template($file, true, true)) {
        $sage_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file), 'File not found');
    }
}, ['helpers', 'setup', 'filters', 'admin', 'ajax']);

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/sage/resources
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/sage/resources/views
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage/resources
 *
 * We do this so that the Template Hierarchy will look in themes/sage/resources/views for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage/resources
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage/resources
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage/resources
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage/resources/views
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/resources
 */
array_map(
    'add_filter',
    ['theme_file_path', 'theme_file_uri', 'parent_theme_file_path', 'parent_theme_file_uri'],
    array_fill(0, 4, 'dirname')
);
Container::getInstance()
    ->bindIf('config', function () {
        return new Config([
            'assets' => require dirname(__DIR__).'/config/assets.php',
            'theme' => require dirname(__DIR__).'/config/theme.php',
            'view' => require dirname(__DIR__).'/config/view.php',
        ]);
    }, true);


/**
 * Change several of the breadcrumb defaults
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'jk_woocommerce_breadcrumbs' );
function jk_woocommerce_breadcrumbs() {
    return array(
            'delimiter'   => ' &ndash; ',
            'wrap_before' => '<nav class="woocommerce-breadcrumb" itemprop="breadcrumb">',
            'wrap_after'  => '</nav>',
            'before'      => '',
            'after'       => '',
            //'home'        => _x( '', 'breadcrumb', 'woocommerce' ),
        );
}

add_filter('woocommerce_get_breadcrumb', 'remove_shop_crumb', 20, 2);
function remove_shop_crumb($crumbs, $breadcrumb)
{
    $new_crumbs = array();
    foreach ($crumbs as $key => $crumb) {
        if ($crumb[0] !== __('Shop', 'Woocommerce')) {
            $new_crumbs[] = $crumb;
        }
    }
    return $new_crumbs;
}


// =========================================================================
// REMOVE ADDITIONAL INFORMATION TAB
// =========================================================================
add_filter( 'woocommerce_product_tabs', 'remove_additional_information_tab', 100, 1 );
function remove_additional_information_tab( $tabs ) {
    unset($tabs['additional_information']);

    return $tabs;
}

// =========================================================================
// ADD ADDITIONAL INFORMATION AFTER ADD TO CART
// =========================================================================
add_action( 'woocommerce_before_add_to_cart_button', 'additional_info_under_add_to_cart', 35 );
function additional_info_under_add_to_cart() {
    global $product;

    if ( $product && ( $product->has_attributes() || apply_filters( 'wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions() ) ) ) {
        wc_display_product_attributes( $product );
    }
}


// add_filter( 'wc360_image_output', 'wcs_360_image_output', 35 );
// function wcs_360_image_output( $content ) {

//     // echo '<div class="">';
//     //     echo $content;
//     // echo '</div>';

//     //return $content = "<div class='myclass'>" . $content . "</div>";
//     return '<div class="custom_class">Whatever goes inside</div>'. $content;
// }


add_filter( 'wc360_output_image_size', 'wcs_360_image_size_output' );
function wcs_360_image_size_output() {
    return 'shop_single';
}

/**
 * @snippet       [recently_viewed_products] Shortcode - WooCommerce
 * @compatible    WooCommerce 3.6.2
 */

add_shortcode( 'recently_viewed_products', 'bbloomer_recently_viewed_shortcode' );

function bbloomer_recently_viewed_shortcode() {
   $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) : array();
   $viewed_products = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );

   if ( empty( $viewed_products ) ) return;
//    $title = '<div class="title__inner"><h2>Recently Viewed</h2></div>';
   $product_ids = implode( ",", $viewed_products );
   return do_shortcode("$product_ids");
}



add_filter( 'acf/fields/wysiwyg/toolbars' , 'my_toolbars'  );
function my_toolbars( $toolbars )
{
	// Uncomment to view format of $toolbars

	// echo '<pre>';
	// 	print_r($toolbars);
	// echo '</pre>';
	// die;


	// Add a new toolbar called "Very Simple"
	// - this toolbar has only 1 row of buttons
	$toolbars['Very Simple' ] = array();
	$toolbars['Very Simple' ][1] = array('formatselect', 'bold' , 'italic' , 'underline', 'link' );

	// Edit the "Full" toolbar and remove 'code'
	// - delet from array code from http://stackoverflow.com/questions/7225070/php-array-delete-by-value-not-key
	if( ($key = array_search('code' , $toolbars['Full' ][2])) !== false )
	{
	    unset( $toolbars['Full' ][2][$key] );
	}

	// remove the 'Basic' toolbar completely
	unset( $toolbars['Basic' ] );

	// return $toolbars - IMPORTANT!
	return $toolbars;
}

add_action( 'init', 'ns_change_post_object' );
// Change dashboard Posts to News
function ns_change_post_object() {
   $get_post_type = get_post_type_object('post');
    $labels = $get_post_type->labels;
    $labels->name = 'Stories';
    $labels->singular_name = 'Story';
    $labels->add_new = 'Add Story';
    $labels->add_new_item = 'Add Story';
    $labels->edit_item = 'Edit Story';
    $labels->new_item = 'Story';
    $labels->view_item = 'View Stories';
    $labels->search_items = 'Search Stories';
    $labels->not_found = 'No Stories found';
    $labels->not_found_in_trash = 'No Stories found in Trash';
    $labels->all_items = 'All Stories';
    $labels->menu_name = 'Stories';
    $labels->name_admin_bar = 'Stories';
}

/**
 * Show cart contents / total Ajax
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;

	ob_start();

	?>
	<a class="cart-customlocation" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><span class="ico-basket"></span><span><?php echo sprintf(_n('(%d)', '(%d)', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?></span></a>
	<?php
	$fragments['a.cart-customlocation'] = ob_get_clean();
	return $fragments;
}


add_filter( 'wpsl_templates', 'custom_templates' );

function custom_templates( $templates ) {

    /**
     * The 'id' is for internal use and must be unique ( since 2.0 ).
     * The 'name' is used in the template dropdown on the settings page.
     * The 'path' points to the location of the custom template,
     * in this case the folder of your active theme.
     */
    $templates[] = array (
        'id'   => 'custom',
        'name' => 'Custom template',
        'path' => get_stylesheet_directory() . '/' . 'wpsl-templates/custom.php',
    );

    return $templates;
}


// Checkout placeholder fields
add_filter( 'woocommerce_checkout_fields' , 'override_billing_checkout_fields', 20, 1 );
function override_billing_checkout_fields( $fields ) {

    $fields['billing']['billing_first_name']['placeholder'] = 'First Name';
    $fields['billing']['billing_last_name']['placeholder'] = 'Last Name';
    $fields['billing']['billing_company']['placeholder'] = 'Company (Optional)';
    $fields['billing']['billing_postcode']['placeholder'] = 'Postcode';
    $fields['billing']['billing_phone']['placeholder'] = 'Phone';
    $fields['billing']['billing_city']['placeholder'] = 'City';
    $fields['billing']['billing_state']['placeholder'] = 'Country (Optional)    ';
    $fields['billing']['billing_email']['placeholder'] = 'Email';


    $fields['shipping']['shipping_first_name']['placeholder'] = 'First Name';
    $fields['shipping']['shipping_last_name']['placeholder'] = 'Last Name';
    $fields['shipping']['shipping_company']['placeholder'] = 'Company (optional)';
    $fields['shipping']['shipping_postcode']['placeholder'] = 'Postcode';
    $fields['shipping']['shipping_phone']['placeholder'] = 'Phone';
    $fields['shipping']['shipping_city']['placeholder'] = 'City';
    // $fields['billing']['shipping_state']['placeholder'] = 'Country (Optional)    ';
    // $fields['billing']['shipping_mail']['placeholder'] = 'Email';

    return $fields;
}


// To change add to cart text on single product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' ); 
function woocommerce_custom_single_add_to_cart_text() {
    return __( 'Add to basket', 'woocommerce' ); 
}

// To change add to cart text on product archives(Collection) page
add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text' );  
function woocommerce_custom_product_add_to_cart_text() {
    return __( 'Add to basket', 'woocommerce' );
}


//Remove WooCommerce breadcrumb
function woocommerce_remove_breadcrumb(){
remove_action( 
    'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
}
add_action(
    'woocommerce_before_main_content', 'woocommerce_remove_breadcrumb'
);

// /**
//  * Get attributes to show.
//  *
//  * @return array
//  */
// function iconic_get_attributes_to_show() {
// 	return apply_filters( 'iconic_get_attributes_to_show', array(
// 		'pa_color',
// 	) );
// }

// Change return to basket link
function store_mall_wc_empty_cart_redirect_url() {
    $url = '/shop/optical/';
    return esc_url( $url );
}
add_filter( 'woocommerce_return_to_shop_redirect', 'store_mall_wc_empty_cart_redirect_url' );


// Remove Image sizes
function wpse_240765_unset_images( $sizes ){
    //unset( $sizes[ 'thumbnail' ]);
    unset( $sizes[ 'medium' ]);
    unset( $sizes[ 'medium_large' ] );
    unset( $sizes[ 'large' ]);
    //unset( $sizes[ 'full' ] );
    return $sizes;
}
add_filter( 'intermediate_image_sizes_advanced', 'wpse_240765_unset_images' );







// Backend: Additional pricing option custom field
add_action( 'woocommerce_product_options_pricing', 'wc_cost_product_field' );
function wc_cost_product_field() {
    woocommerce_wp_text_input( array(
        'id'        => '_nosepad_price',
        'class'     => 'wc_input_price short',
        'label'     => __( 'Nosepad Cost', 'woocommerce' ) . ' (' . get_woocommerce_currency_symbol() . ')'
    ));
}

// Backend: Saving product pricing option custom field value
add_action( 'woocommerce_admin_process_product_object', 'save_product_custom_meta_data', 100, 1 );
function save_product_custom_meta_data( $product ){
    if ( isset( $_POST['_nosepad_price'] ) )
        $product->update_meta_data( '_nosepad_price', sanitize_text_field($_POST['_nosepad_price']) );
}

// Front: Add a text input field inside the add to cart form on single product page
add_action('woocommerce_single_product_summary','add_nosepad_price_option_to_single_product', 2 );
function add_nosepad_price_option_to_single_product(){
    global $product;

    if( $product->is_type('variable') || ! $product->get_meta( '_nosepad_price' ) ) return;

    add_action('woocommerce_after_add_to_cart_button', 'product_option_custom_field', 90 );
}

function product_option_custom_field(){
    global $product;

    $active_price = (float) $product->get_price();
    $nosepad_price = (float) $product->get_meta( '_nosepad_price' );
    $nosepad_price_html   = strip_tags( wc_price( wc_get_price_to_display( $product, array('price' => $nosepad_price ) ) ) );
    $active_price_html   = wc_price( wc_get_price_to_display( $product ) );
    $disp_price_sum_html = wc_price( wc_get_price_to_display( $product, array('price' => $active_price + $nosepad_price ) ) );

    echo '<div class="hidden-field">
    <p class="form-row form-row-wide" id="nosepads_option_field" data-priority="">
    <span class="woocommerce-input-wrapper">
    <input type="checkbox" class="input-checkbox " name="nosepad_option" id="nosepad_option" value="1">
        <label class="checkbox"> ' . __("Add nosepads to my frame", "Woocommerce") .
        ' + ' . $nosepad_price_html . '</label></span></p>
    <input type="hidden" name="nosepad_price" value="' . $nosepad_price . '">
    <input type="hidden" name="active_price" value="' . $active_price . '"></div>';

    // Jquery: Update displayed price
    ?>
    <script type="text/javascript">
    jQuery(function($) {
        var cb = 'input[name="nosepad_option"]'
            pp = 'p.price';

        // On change / select a variation
        $('form.cart').on( 'change', cb, function(){
            if( $(cb).prop('checked') === true )
                $(pp).html('<?php echo $disp_price_sum_html; ?>');
            else
                $(pp).html('<?php echo $active_price_html; ?>');
        })

    });
    </script>
    <?php
}

// Front: Calculate new item price and add it as custom cart item data
add_filter('woocommerce_add_cart_item_data', 'add_custom_product_data', 10, 3);
function add_custom_product_data( $cart_item_data, $product_id, $variation_id ) {
    if (isset($_POST['nosepad_option']) && !empty($_POST['nosepad_option'])) {
        $cart_item_data['new_price'] = (float) ($_POST['active_price'] + $_POST['nosepad_price']);
        $cart_item_data['nosepad_price'] = (float) $_POST['nosepad_price'];
        $cart_item_data['active_price'] = (float) $_POST['active_price'];
        $cart_item_data['unique_key'] = md5(microtime().rand());
    }

    return $cart_item_data;
}

// Front: Set the new calculated cart item price
add_action('woocommerce_before_calculate_totals', 'extra_price_add_custom_price', 20, 1);

function extra_price_add_custom_price($cart) {
    if (is_admin() && !defined('DOING_AJAX'))
        return;

    if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 )
        return;

    foreach($cart->get_cart() as $cart_item) {
        if (isset($cart_item['new_price']))
            $cart_item['data']->set_price((float) $cart_item['new_price']);
    }
}

// Front: Display option in cart item
add_filter('woocommerce_get_item_data', 'display_custom_item_data', 10, 2);

function display_custom_item_data($cart_item_data, $cart_item) {
    if (isset($cart_item['nosepad_price'])) {
        $cart_item_data[] = array(
            'name' => __("Nosepad option", "woocommerce"),
            'value' => strip_tags( '+ ' . wc_price( wc_get_price_to_display( $cart_item['data'], array('price' => $cart_item['nosepad_price'] ) ) ) )
        );
    }

    return $cart_item_data;
}

// Save chosen seats to each order item as custom meta data and display order items Warrenty everywhere
add_action('woocommerce_checkout_create_order_line_item', 'save_order_item_product_waranty', 10, 4 );
function save_order_item_product_waranty( $item, $cart_item_key, $values, $order ) {
    if( isset($values['nosepad_price']) && $values['nosepad_price'] > 0 ) {
        $key = __("Nosepad option", "woocommerce");
        $value = strip_tags( '+ '. wc_price( wc_get_price_to_display( $values['data'], array('price' => $values['nosepad_price']) ) ) );
        $item->update_meta_data( $key, $value );
    }
}

function prefix_wishlist_template_location( $template_hook, $product_id ) {
    // Return your hook here
    return 'woocommerce_after_add_to_cart_quantity';
  }
add_filter( 'woocommerce_wishlists_template_location', 'prefix_wishlist_template_location', 10, 2 );


//
// Create Professional User Role */
//
add_role(
    'professional', //  System name of the role.
    __( 'Professional'  ), // Display name of the role.
    array(
        'read'  => false,
        'delete_posts'  => false,
        'delete_published_posts' => false,
        'edit_posts'   => false,
        'publish_posts' => false,
        'upload_files'  => false,
        'edit_pages'  => false,
        'edit_published_pages'  =>  false,
        'publish_pages'  => false,
        'delete_published_pages' => false, // This user will NOT be able to  delete published pages.
    )
);
// function wps_remove_role() {
//     remove_role( 'professional' );
// }
// add_action( 'init', 'wps_remove_role' );


// add_action( 'widgets_init', 'override_woocommerce_widgets', 15 );
// function override_woocommerce_widgets() {
//   // Ensure our parent class exists to avoid fatal error (thanks Wilgert!)

//   if ( class_exists( 'WC_Widget_Layered_Nav' ) ) {
//     unregister_widget( 'WC_Widget_Layered_Nav' );

//     include_once( 'widget/class-wc-widget-layered-nav.php' );

//     register_widget( 'WC_Widget_Layered_Nav' );
//   }

// }