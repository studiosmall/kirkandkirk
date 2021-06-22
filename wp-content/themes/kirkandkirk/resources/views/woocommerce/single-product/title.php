<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @package    WooCommerce\Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;

?>

<?php
// echo wc_get_product_category_list( $product->get_id(), ', ', '
// <span class="posted_in">' . _n( 'Category:', 'Categories:',
// count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' );

	$collection = get_field('collection');
?>

<?php if($collection) { ?>
	<span class="posted_in"><?php echo $collection; ?></span>
<?php } ?>

<?php //echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( '', '', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>

<?php

	$theTitle = get_the_title();

	if (str_contains($theTitle, '-')) { 
    $newTitle = substr($theTitle, 0, strpos($theTitle, '-'));
	} else {
		$newTitle = get_the_title();
	}
?>

<h1 class="product_title entry-title">
	<?php echo $newTitle; ?>
</h1>

<?php // the_title( '<h1 class="product_title entry-title">', '</h1>' );
