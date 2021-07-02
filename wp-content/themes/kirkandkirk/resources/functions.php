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


/// ADDED FROM OLD SITE
include(get_stylesheet_directory().'/acf-userDynamic-role.php');

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

//
// Remove product data */
//
add_filter( 'woocommerce_product_data_tabs', 'custom_product_data_tabs' ); 
function custom_product_data_tabs( $tabs ) {
  // unset( $tabs['general'] );
  //unset( $tabs['inventory'] );
  //unset( $tabs['shipping'] );
  unset( $tabs['linked_product'] );
  //unset( $tabs['attribute'] );
 // unset( $tabs['variations'] );
 // unset( $tabs['advanced'] );
  return $tabs;
}

//
// Remove product data items */
//
add_filter( 'product_type_selector', 'remove_product_types' );
function remove_product_types( $types ){
    unset( $types['grouped'] );
    unset( $types['external'] );
    //unset( $types['variable'] );
    return $types;
}

//
// Remove Virtual and Downloadable */
//
add_filter( 'product_type_options', function( $options ) {
	// remove "Virtual" checkbox
	if( isset( $options[ 'virtual' ] ) ) {
		unset( $options[ 'virtual' ] );
	}
	// remove "Downloadable" checkbox
	if( isset( $options[ 'downloadable' ] ) ) {
		unset( $options[ 'downloadable' ] );
	}
	return $options;
} );


//
// Redirect on logout */
//
add_action('wp_logout','auto_redirect_after_logout');
function auto_redirect_after_logout(){

  wp_redirect( home_url() );
  exit();

}

/**
 * Bypass logout confirmation.
 */
function iconic_bypass_logout_confirmation() {
	global $wp;

	if ( isset( $wp->query_vars['customer-logout'] ) ) {
		wp_redirect( str_replace( '&amp;', '&', wp_logout_url( wc_get_page_permalink( 'myaccount' ) ) ) );
		exit;
	}
}

add_action( 'template_redirect', 'iconic_bypass_logout_confirmation' );



// function juditmatyus_availability( $availability, $product ){
//     // Change "x in stock" text to "Only x left"
//     $new_availability_text = 'Low Stock (' . str_replace("in stock", ")", $availability['availability']);
//     $availability['availability'] = $new_availability_text;

//    // Change "out of stock" text to "Sold Out"
//     if( $availability['class'] == 'out-of-stock' ){
//       $availability['availability'] = 'Sold Out';
//     }
//     return $availability;
// }
// add_filter( 'woocommerce_get_availability', 'juditmatyus_availability', 10, 2 );


// add_filter( 'woocommerce_get_availability', 'custom_get_availability', 1, 2);

// function custom_get_availability( $availability, $_product ) {
//   global $product;
//   $stock = $product->get_stock_quantity();

//   if($stock <= 5){
//     if ($_product->is_in_stock() ) $availability['availability'] = __('Low Stock (fewer than ' . $stock . ')', 'woocommerce');
//   }

//   return $availability;
// }

// add_filter('woocommerce_get_availability', 'availability_filter_func');
// function availability_filter_func($availability)
// {
// $availability['availability'] = str_ireplace('In stock', '', $availability['availability']);
// return $availability;
// }

// add_filter( 'woocommerce_get_availability_text', 'bbloomer_custom_get_availability_text', 99, 2 );
// function bbloomer_custom_get_availability_text( $availability, $product ) {
    
//     $stock = $product->get_stock_quantity();
//     if ( $product->is_in_stock() && $stock < 5 ) {
//         if ($stock == 1) {
//             $verb = "is";
//         } else {
//             $verb = "are";
//         }
//         $availability = "Low Stock (fewer than " . $stock . ")";
//         //$availability = "Low Stock (fewer than " . $verb . " " . $stock . ")";
//     } else {
//         $availability = "";
//     }

//     return $availability;
// }


add_filter('body_class', 'custom_outofstock_class');

 function custom_outofstock_class ($classes) {

  global $post;
  if($post->post_type !="product")
    return $classes;
  $product = wc_get_product( $post->ID );
  if($product->get_stock_quantity() ==0)
    $classes[] = 'out-of-stock';
  return $classes;
}


///// Optician START
//////////////////////////////////

/* Optician Single custom add to cart ajax function */
function hb_optician_single_add_to_cart_data_callback()
{
    $user_id = get_current_user_id();
    $product_data = $_POST['formdata'];
    $cart_products_data = array();
    /*echo $user_id;print_r($product_data);*/

    // var_dump($product_data);
    // var_dump($product_data['product_id']);
    // var_dump('hello');
    //var_dump($product_data);

    $optician_cart_data = get_user_meta($user_id, 'optician_cart_data', true);
    $optician_cart_data_array = unserialize($optician_cart_data);

    //var_dump($optician_cart_data_array);

    if (!empty($optician_cart_data_array[0])) {
        $cart_products_data = $optician_cart_data_array;
    }
    if (array_search($product_data['variation_id'], array_column($cart_products_data, 'variation_id')) === false) {
        array_push($cart_products_data, $product_data);
    } else {
        $search_key = hb_search_for_variation_id($product_data['variation_id'], $cart_products_data, array());
        /*echo "ss=>";print_r($search_key);*/
        if (!empty($search_key)) {
            $cart_products_data[$search_key]['quantity'] = intval($cart_products_data[$search_key]['quantity']) + intval($product_data['quantity']);
            // if( isset( $product_data['optician_left'] ) ){
            //     $cart_products_data[$search_key]['optician_left'] = $product_data['optician_left'];
            // }
            /*else{
                unset( $cart_products_data[$search_key]['optician_left'] );
            }*/
            // if( isset( $product_data['optician_right'] ) ){
            //     $cart_products_data[$search_key]['optician_right'] = $product_data['optician_right'];
            // }
            /*else{
                unset( $cart_products_data[$search_key]['optician_right'] );
            }*/
        }
    }
    $optician_cart_data_array = $cart_products_data;
    update_user_meta($user_id, 'optician_cart_data', serialize($optician_cart_data_array));
    echo get_permalink($product_data['product_id']) . '?optician_add_item='.$product_data['variation_id'];
    die();
}
add_action("wp_ajax_hb_optician_single_add_to_cart_data", "hb_optician_single_add_to_cart_data_callback");


/* Optician custom add to cart ajax function */
function hb_optician_add_to_cart_data_callback()
{
    $user_id = get_current_user_id();
    $product_data = $_POST['formdata'];
    $cart_products_data = array();
    /*echo $user_id;print_r($product_data);*/

    //var_dump($product_data['product_id']);
    var_dump($product_data);

    $optician_cart_data = get_user_meta($user_id, 'optician_cart_data', true);
    $optician_cart_data_array = unserialize($optician_cart_data);

   // var_dump($optician_cart_data_array);

    if (!empty($optician_cart_data_array[0])) {
        $cart_products_data = $optician_cart_data_array;
    }
    if (array_search($product_data['variation_id'], array_column($cart_products_data, 'variation_id')) === false) {
        array_push($cart_products_data, $product_data);
    } else {
        $search_key = hb_search_for_variation_id($product_data['variation_id'], $cart_products_data, array());
        /*echo "ss=>";print_r($search_key);*/
        if (!empty($search_key)) {
            $cart_products_data[$search_key]['quantity'] = intval($cart_products_data[$search_key]['quantity']) + intval($product_data['quantity']);
            // if( isset( $product_data['optician_left'] ) ){
            //     $cart_products_data[$search_key]['optician_left'] = $product_data['optician_left'];
            // }
            /*else{
                unset( $cart_products_data[$search_key]['optician_left'] );
            }*/
            // if( isset( $product_data['optician_right'] ) ){
            //     $cart_products_data[$search_key]['optician_right'] = $product_data['optician_right'];
            // }
            /*else{
                unset( $cart_products_data[$search_key]['optician_right'] );
            }*/
        }
    }
    $optician_cart_data_array = $cart_products_data;
    update_user_meta($user_id, 'optician_cart_data', serialize($optician_cart_data_array));
    echo get_permalink($product_data['product_id']) . '?optician_add_item='.$product_data['variation_id'];
    die();
}
add_action("wp_ajax_hb_optician_add_to_cart_data", "hb_optician_add_to_cart_data_callback");

/* Get already exist variation id */
function hb_search_for_variation_id($search_value, $array, $id_path)
{
    if (!empty($array[0])) {
        // Iterating over main array
        foreach ($array as $key1 => $val1) {
            $temp_path = $id_path;

            // Adding current key to search path
            array_push($temp_path, $key1);

            // Check if this value is an array
            // with atleast one element
            if (is_array($val1) and count($val1)) {
                // Iterating over the nested array
                foreach ($val1 as $key2 => $val2) {
                    if ($val2 == $search_value) {
                        // Adding current key to search path
                        array_push($temp_path, $key2);

                        return $temp_path[0];
                        // return join(" a--> ", $temp_path);
                    }
                }
            }
            /*elseif($val1 == $search_value) {
                return join(" b--> ", $temp_path);
            } */
        }
    }
    return null;
}

/* Remove item in optician cart */
function hb_optician_remove_item_callback()
{
    $cart_products_data = array();
    $user_id = get_current_user_id();
    $variation_id = $_POST['variation_id'];

    $optician_cart_data = get_user_meta($user_id, 'optician_cart_data', true);
    $optician_cart_data_array = unserialize($optician_cart_data);
    /*echo "remove_ajax_response=><pre>";
    print_r($optician_cart_data_array);
    echo "</pre>";*/
    if (!empty($optician_cart_data_array[0])) {
        $cart_products_data = $optician_cart_data_array;
    }

    $search_key = hb_search_for_variation_id($variation_id, $cart_products_data, array());
    unset($cart_products_data[$search_key]);

    $optician_cart_data_array = array_values(array_filter($cart_products_data));

    update_user_meta($user_id, 'optician_cart_data', serialize($optician_cart_data_array));
    /*if( count($cart_products_data) > 0 ){
        echo "remove_item";
    }else{
        echo "remove_all";
    }*/
    echo esc_url(wc_get_cart_url()) . "?optician_remove_item=$variation_id";
    die();
}
add_action("wp_ajax_hb_optician_remove_item", "hb_optician_remove_item_callback");

require_once 'hbMiniCart.php';

// register Hb_Mini_Cart widget
function register_hb_mini_cart()
{
    register_widget('Hb_Mini_Cart');
}
if (current_user_can('optician') || is_admin()) {
    add_action('widgets_init', 'register_hb_mini_cart');
}

/* Place optician order */
function hb_optician_checkout_order_callback()
{
    $headers = $optician_cart_data_array = array();
    $cart_content = '';
    $references = $_POST['references'];
    $name_of_store = $_POST['name_of_store'];
    $ordernote = $_POST['ordernote'];
    $user_id = get_current_user_id();
    $current_user = wp_get_current_user();
    $optician_email = $current_user->user_email;
    $optician_name = $current_user->display_name;
    $admin_email = get_option("admin_email");
    $blog_name = get_bloginfo("name");

    $headers[] = "From: $blog_name <$admin_email>";
    $headers[] = "Bcc: rowan@studiosmall.com";
    // $headers[] = "Bcc: karen@kirkandkirk.com";
    // $headers[] = "Bcc: karen@kirkandkirk.com";
    $headers[] = "Content-Type: text/html; charset=UTF-8";

    $optician_cart_data = get_user_meta($user_id, 'optician_cart_data', true);
    $optician_cart_data_array = unserialize($optician_cart_data);
    /*echo "optician_mail_ajax_response=><pre>";
    print_r($optician_cart_data_array);
    echo "</pre>";*/
    $cart_content .= "<html><body style='margin:0;'>";
    $cart_content .= '<table style="width: 600px; margin: 0 auto; ">
        <tr>
            <td style="width: 100% margin-top: 50px;">
                <p style="margin-top: 50px; margin-bottom: 20px;"><img src="https://kirkstaging.wpengine.com/wp-content/uploads/2021/07/k-and-k-logo-1.png" alt="Kirk &amp; Kirk" style="border: none; display: inline-block; font-size: 14px; font-weight: bold; height: auto; outline: none; text-decoration: none; text-transform: capitalize; vertical-align: middle; margin-left: 0; margin-right: 0; max-width: 200px;"></p>
                <p>Hello '.$optician_name.',<br /></p>
                <p>Thank you for placing an Order we`ll be reaching out to you soon.<br /><br /><br /></p>
            </td>
        </tr>
        <tr>
            <td style="width: 100%">
              <table cellspacing="0" style=" width:100%; border: 1px solid rgba(0,0,0,.1); text-align: left; border-collapse: separate; border-radius: 5px">
            <thead>
                <tr>
                    <th style=" font-weight: 700; padding: 9px 12px; line-height: 1.5em;">&nbsp;</th>
                    <th style=" font-weight: 700; padding: 9px 12px; line-height: 1.5em;">'.__('Product', 'woocommerce').'</th>
                    <th style=" font-weight: 700; padding: 9px 12px; line-height: 1.5em;">'.__('Quantity', 'woocommerce').'</th>
                    <th style=" font-weight: 700; padding: 9px 12px; line-height: 1.5em;">'.__('Reference', 'woocommerce').'</th>
                </tr>
            </thead>
            <tbody>';
    if (!empty($optician_cart_data_array[0])) {
        foreach ($optician_cart_data_array as $cart_item_key => $cart_item) {
            $product_id = $cart_item['product_id'];
            $variation_id = $cart_item['variation_id'];
            $variation_title = get_the_title($variation_id);
            $variation_title = $variation_title ? $variation_title : '';
            $attachment_id = get_post_meta($variation_id, '_thumbnail_id', true);
            $_product = wc_get_product($product_id);

            if ($_product && $_product->exists()) {
                $product_permalink = get_permalink($variation_id);
                $cart_content .= '<tr>
                    <td style=" font-weight: 400; padding: 9px 12px; line-height: 1.5em; border-top: 1px solid rgba(0,0,0,.1);">';
                $thumbnail = wp_get_attachment_image($attachment_id, array(60, 40));

                if (! $product_permalink) {
                    $cart_content .= $thumbnail;
                } else {
                    $cart_content .= '<a href="'.esc_url($product_permalink).'">'.$thumbnail.'</a>';
                }
                $cart_content .= '</td>
                    <td style=" font-weight: 400; padding: 9px 12px; line-height: 1.5em; border-top: 1px solid rgba(0,0,0,.1);">';
                if (! $product_permalink) {
                    $cart_content .= wp_kses_post($variation_title);
                } else {
                    $cart_content .= wp_kses_post(sprintf('<a href="%s" style="text-decoration: none; color: #000;">%s</a>', esc_url($product_permalink), $variation_title));
                }
                $cart_content .= '</td>';
                //     <td style=" font-weight: 400; padding: 9px 12px; line-height: 1.5em; border-top: 1px solid rgba(0,0,0,.1);">';
                // $temples_arr = array();
                // if (isset($cart_item['optician_left'])) {
                //     array_push($temples_arr, $cart_item['optician_left']);
                // }
                // if (isset($cart_item['optician_right'])) {
                //     array_push($temples_arr, $cart_item['optician_right']);
                // }
                // $temples = implode(", ", $temples_arr);
                // if (!isset($cart_item['optician_left']) && !isset($cart_item['optician_right'])) {
                //     $temples = __('Frame(s)', 'woocommerce');
                // }

                // $cart_content .= $temples;
                // $cart_content .= '</td>
                    $cart_content .= '<td style=" font-weight: 400; padding: 9px 12px; line-height: 1.5em; border-top: 1px solid rgba(0,0,0,.1);">'.$cart_item['quantity'].'</td>';
                $cart_content .= '<td style=" font-weight: 400; padding: 9px 12px; line-height: 1.5em; border-top: 1px solid rgba(0,0,0,.1);">'.$references[$cart_item_key].'</td>
                    </tr>';
            }
        }
        $cart_content .= '</table>
            </td>
        </tr>
        <tr>
            <td style="width: 100%">
            <p><br /><br /><br /></p>
            </td>
        </tr>
        </tbody>
        </table>';
        $cart_content .= '<div style=" font-weight: 400; padding: 9px 55px; line-height: 1.5em; border-top: 1px solid rgba(0,0,0,.1);"> '.__(' Name of Store: ' ).$name_of_store.'</div>';
        $cart_content .= '<div style=" font-weight: 400; padding: 9px 55px; line-height: 1.5em; border-top: 1px solid rgba(0,0,0,.1);">'.__('Order Note: ' ).$ordernote.'</div>';
        $cart_content .='</body>
    </html>';

        $result = wp_mail($optician_email, "Kirk and Kirk – Order placed successfully!", $cart_content, $headers);
        if ($result) {
            /*echo "mail send!";*/
            if (! delete_user_meta($user_id, 'optician_cart_data')) {
                $delete_failed = "Ooops! Error while deleting cart content!";
            }
            echo home_url('/optician-thankyou/');
        } else {
            /*echo "mail sending failed!";*/
            echo esc_url(wc_get_cart_url()) . '?optician_placeorder=false';
        }
    }
    die();
}
add_action("wp_ajax_hb_optician_checkout_order", "hb_optician_checkout_order_callback");



/*Notice after Add to cart product */
add_action('woocommerce_before_single_product', 'wc_add_to_cart_message_html_optician', 10);
function wc_add_to_cart_message_html_optician()
{
    if (isset($_GET['optician_add_item']) && $_GET['optician_add_item'] != '') {
        $variation_title = get_the_title($_GET['optician_add_item']);
        $message = "<a href='".esc_url(wc_get_cart_url())."' tabindex='1' class='button wc-forward'>View cart</a> $variation_title has been added to your cart.";
        wc_print_notice($message, 'notice');
    }
}

/* Notice after remove optiocian cart item */
add_action('woocommerce_before_cart', 'after_remove_optician_item_notification');
function after_remove_optician_item_notification()
{
    if (isset($_GET['optician_remove_item']) && $_GET['optician_remove_item'] != '') {
        $variation_title = get_the_title($_GET['optician_remove_item']);
        $message = "$variation_title removed!";
        wc_print_notice($message, 'notice');
    }
}

/* Notice after failed optiocian order */
add_action('woocommerce_before_cart', 'after_failed_optiocian_order_notification');
function after_failed_optiocian_order_notification()
{
    if (isset($_GET['optician_placeorder']) && $_GET['optician_placeorder'] == 'false') {
        $message = "Order can't be placed due to some reason! Please contact admin.";
        wc_print_notice($message, 'error');
    }
}

/* Remove out of stock label for optician */
function sww_wc_remove_variation_stock_display($data)
{
    if (current_user_can('optician')) {
        unset($data['availability_html']);
    }
    return $data;
}
add_filter('woocommerce_available_variation', 'sww_wc_remove_variation_stock_display', 99);

add_filter( 'wp_new_user_notification_email', 'custom_wp_new_user_notification_email', 10, 3 );
function custom_wp_new_user_notification_email( $wp_new_user_notification_email, $user_id, $blogname ) {
$user = new WP_User($user_id);
$user_login = stripslashes($user->user_login);
$user_email = stripslashes($user->user_email);
$key = wp_generate_password( 20, false );
$link=site_url("wp-login.php?action=rp&key=$key&login=" .rawurlencode($user->user_login), 'login');
$link_login=site_url('wp-login.php');
do_action( 'retrieve_password_key', $user->user_login, $key );

global $wpdb;
if ( empty( $wp_hasher ) ) {
require_once ABSPATH . WPINC . '/class-phpass.php';
$wp_hasher = new PasswordHash( 8, true );
}
$hashed = time() . ':' . $wp_hasher->HashPassword( $key );
$wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $user->user_login ) );

$wp_new_user_notification_email['message'] = '';
$wp_new_user_notification_email['message'] .= sprintf(__('Username: %s'), $user->user_login) . "\r\n".'<br>';
$wp_new_user_notification_email['message'] .= __('To set your password, visit the following address:') ."<br/><br/>";

$wp_new_user_notification_email['message'] .=" <a href=".$link.">Click here<br/></a>";
$wp_new_user_notification_email['message'] .= "<br/>OR <br/>";
$wp_new_user_notification_email['message'] .="<br><a href='".$link_login."'>Click here for login</a>";



$wp_new_user_notification_email['subject'] =  __('Login Details ');
$wp_new_user_notification_email['headers'] = 'Content-Type: text/html; charset=UTF-8';
return $wp_new_user_notification_email;
}


// /**
//  * Optician extra menu item
//  */
add_filter ( 'woocommerce_account_menu_items', 'wptips_customize_account_menu_items' );
function wptips_customize_account_menu_items( $menu_items ){
     // Add new Custom URL in My Account Menu 
    $new_menu_item = array('contact-us'=>'Order');  // Define a new array with cutom URL slug and menu label text
    $new_menu_item_position=2; // Define Position at which the New URL has to be inserted
    
    array_splice( $menu_items, ($new_menu_item_position-1), 0, $new_menu_item );
    return $menu_items;
}
// point the endpoint to a custom URL
add_filter( 'woocommerce_get_endpoint_url', 'wptips_custom_woo_endpoint', 10, 2 );
function wptips_custom_woo_endpoint( $url, $endpoint ){
    $siteurl = site_url(''); 
    if( $endpoint == 'contact-us' ) {
        $url = ''. $siteurl . '/collections/optical'; // Your custom URL to add to the My Account menu
    }
    return $url;
}

add_filter ( 'woocommerce_account_menu_items', 'download_customize_account_menu_items' );
function download_customize_account_menu_items( $menu_items ){
     // Add new Custom URL in My Account Menu 
    $new_menu_item = array('downloads'=>'Downloads');  // Define a new array with cutom URL slug and menu label text
    $new_menu_item_position=3; // Define Position at which the New URL has to be inserted
    
    array_splice( $menu_items, ($new_menu_item_position-1), 0, $new_menu_item );
    return $menu_items;
}
// point the endpoint to a custom URL
add_filter( 'woocommerce_get_endpoint_url', 'download_custom_woo_endpoint', 10, 2 );
function download_custom_woo_endpoint( $url, $endpoint ){
    $siteurl = site_url(''); 
    if( $endpoint == 'downloads' ) {
        $url = ''. $siteurl . '/downloads'; // Your custom URL to add to the My Account menu
    }
    return $url;
}

// /**
//  * remove downloads
//  */
function custom_my_account_menu_items( $items ) {
    unset($items['downloads']);
    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'custom_my_account_menu_items' );


// /**
//  * Optician 
//  */
// function my_login_redirect( $redirect_to, $request, $user ) {
//     //is there a user to check?
//     global $user;
//     if ( isset( $user->roles ) && is_array( $user->roles ) ) {

//         if ( in_array( 'optician', $user->roles ) ) {
//             // redirect them to the default place
//             $data_login = get_option('axl_jsa_login_wid_setup');

//             return get_permalink($data_login[0]);
//         } else {
//             return home_url();
//         }
//     } else {
//         return $redirect_to;
//     }
// }
// add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );

/**
 * Change number of products that are displayed per page (shop page)
 */
add_filter( 'loop_shop_per_page', 'wc_redefine_products_per_page', 9999 );

function wc_redefine_products_per_page( $per_page ) {
  $per_page = 9999;
  return $per_page;
}


/**
 * Show the product title in the product loop. By default this is an H2.
 */
// function action_woocommerce_shop_loop_item_title() {
//     // Removes a function from a specified action hook.
//     remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
    
//     $theTitle = get_the_title();

// 	if (str_contains($theTitle, '-')) { 
//     $newTitle = substr($theTitle, 0, strpos($theTitle, '-'));
// 	} else {
// 		$newTitle = get_the_title();
// 	}


//     echo '<h2 class="fuck' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '">' . get_the_title() . '</h2>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
// }
// add_action( 'woocommerce_shop_loop_item_title', 'action_woocommerce_shop_loop_item_title', 9 );

// remove_action( 'woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title', 10 );
// add_action('woocommerce_shop_loop_item_title', 'abChangeProductsTitle', 10 );
// function abChangeProductsTitle() {
    
//     $theTitle = get_the_title();

// 	if (strpos($theTitle, '-')) { 
//         $newTitle = substr($theTitle, 0, strpos($theTitle, '-'));
//         echo '<h2 class="woocommerce-loop-product__title">' . $newTitle . '</h2>';
//         echo 'here 1';
// 	} else {
// 		$newTitle = get_the_title();
//         echo '<h2 class="woocommerce-loop-product__title">' . $newTitle . '</h2>';
//         echo 'here 2';
// 	}
// }


function add_login_check()
{
    if (is_user_logged_in()) {
        if (is_page(1340)){
            wp_redirect('/#optician');
            exit; 
        }
    }
}

add_action('wp', 'add_login_check');