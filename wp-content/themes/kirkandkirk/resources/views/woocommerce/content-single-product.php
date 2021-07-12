<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>


<?php woocommerce_breadcrumb();?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

	<div class="product-images">
		<div class="product-images__inner">

		<?php
		/**
		 * Hook: woocommerce_before_single_product_summary.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );

		?>

		<div class="product-images__360">
			<span class="ico-360"></span>
		</div>


		<?php
			$lifestyleImages = get_field('images');
		?>

		<?php if($lifestyleImages) { ?>
			<?php foreach($lifestyleImages as $item) : ?>

				<?php
					$type            = $item['image_type'];

					$lifestyleImage  = $item['image'];
					$height 			   = $lifestyleImage['height'];
					$width  				 = $lifestyleImage['width'];
				?>

				<?php if($type == 'single') { ?>

					<?php if($lifestyleImage) { ?>
						<div class="lifestyle <?php if($width >= $height ) { echo 'landscape'; } else { echo 'portrait'; } ?>">
							<img src="<?php echo $lifestyleImage['url']; ?>" alt="<?php echo $lifestyleImage['title']; ?>">
						</div>
					<?php } ?>

				<?php } elseif($type == 'double') { ?>
					<?php
						$doubleImage    = $item['double'];
					?>

					<div class="double-image">
						<?php foreach($doubleImage as $images) : ?>
							<img class="portrait-img" src="<?php echo $images['portrait_image']; ?>">
						<?php endforeach ?>
					</div>
				<?php } ?>

				<?php endforeach ?>
		<?php } ?>

		<?php //if($image) { ?>
			<!-- <img src="<?php  //echo $image[0]; ?>" data-id="<?php //echo $loop->post->ID; ?>"> -->
		<?php// } ?>
		</div>
	</div>

	<div class="summary entry-summary">

		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		// remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
		// add_action( 'woocommerce_after_single_product_summary', 'woocommerce_template_single_excerpt', 30 );

		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
		add_action( 'woocommerce_single_product_summary', 'the_content', 10 );


		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title',5);
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price',10);
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt',20);
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart',30);
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta',40);
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing',50);

		add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title',5);
		add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price',5);
		add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt',20);
		add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta',40);
		add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart',50);
		add_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing',60);


		// add_action( 'woocommerce_after_add_to_cart_button', array(  $GLOBALS['Product_Addon_Display'], 'display' ), 40 );
		// add_action( 'woocommerce_before_add_to_cart_button', array(  $GLOBALS['Product_Addon_Display'], 'totals' ), 50 );

		// remove_action('woocommerce_before_add_to_cart_button', array( $GLOBALS['Product_Addon_Display'], 'display' ), 10 );
		// add_action( 'woocommerce_before_variations_form', array( $GLOBALS['Product_Addon_Display'], 'display' ), 50 );

		do_action( 'woocommerce_single_product_summary' );

		?>

	</div>
</div>

<?php
	$review = get_field('product_review', 'option');
?>

	<?php if($review) { ?>
		<section class="review">
			<div class="review__inner">
				<div class="slider-review">
					<?php foreach($review as $r): ?>
						<div>
							<div class="review-slider">
								<div class="review-slider__col">
									<div class="review-slider__stars">
										<?php if($r['stars'] == 'one'){
											echo '<span class="star star__one"></span>';
										} elseif($r['stars'] == 'two') {
											echo '<span class="star star__two"></span>';
										} elseif($r['stars'] == 'three') {
											echo '<span class="star star__three"></span>';
										} elseif($r['stars'] == 'four') {
											echo '<span class="star star__four"></span>';
										} elseif($r['stars'] == 'five') {
											echo '<span class="star star__five"></span>';
										} ?>
									</div>

								</div>
								<div class="review-slider__col">
									<div class="review-slider__quote">
										<p>“<?php echo $r['review']; ?>”</p>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach ?>
				</div>

			</div>
		</section>
	<?php } ?>

	<?php 
		$instagram = get_field('instagram', 'option');
		$productInstagram = get_field('instagram');
	?>

	<?php if($productInstagram['instagram_images']) { ?>
		<section class="instagram">
			<div class="instagram__inner">
				<h3>Latest on Instagram</h3>

				<div class="feed">
					<?php foreach($productInstagram['instagram_images'] as $i): ?>
						<div class="feed__item">
							<a href="<?php echo $i['image_url'] ?>" target="_bank">
								<div class="image-container">
									<img src="<?php echo $i['image']['url'] ?>" alt="Kirk and Kirk – Instagram">
								</div>
							</a>
						</div>
					<?php endforeach ?>
				</div>
			</div>
		</section>
	<?php } elseif($instagram['instagram_images']) { ?>

		<section class="instagram">
			<div class="instagram__inner">
				<h3>Latest on Instagram</h3>

				<div class="feed">
					<?php foreach($instagram['instagram_images'] as $i): ?>
						<div class="feed__item">
							<a href="<?php echo $i['image_url'] ?>" target="_bank">
								<div class="image-container">
									<img src="<?php echo $i['image']['url'] ?>" alt="Kirk and Kirk – Instagram">
								</div>
							</a>
						</div>
					<?php endforeach ?>
				</div>
			</div>
		</section>
	
	<?php } else { ?>


	<?php } ?>

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>


<?php

	$shortcode 	  = do_shortcode('[recently_viewed_products]');
	$recently 	  = explode(',', $shortcode);
	$num_recently = count($recently);
		
	//echo do_shortcode('[woocommerce_recently_viewed_products]');
?>


<?php if(($num_recently >= 3)) { ?>
	<section class="featured-products recently">
		<div class="featured-products__inner">

			<div class="title__inner">
				<h2>Recently viewed</h2>
			</div>

			<div class="featured-products__products slider">
			<?php foreach($recently as $product) : ?>
				<?php
							//$product  = wc_get_product($product);
							$currency = get_woocommerce_currency_symbol();
							$price    = get_post_meta( get_the_ID(), '_regular_price', true);
							$sale     = get_post_meta( get_the_ID(), '_sale_price', true);

							$image 		= get_the_post_thumbnail_url($product);
							$link 		= get_permalink($product);
							$title 		= get_the_title($product);
							$fields  	= get_fields($product);

							$textarea  = $fields['textarea'];
							$colour    = $fields['product_colour'];

						?>
				<?php if($link) { ?>

					<div class="featured-products__product">

						<a class="link" href="<?php echo $link; ?>"></a>

						<div class="image-container">
							<img src="<?php echo $image; ?>"  alt="<?php echo $title; ?>">
						</div>

						<div class="featured-products__meta" style="border-color:<?php echo $colour; ?>">
							<h1><?php echo $title; ?></h1>
							<?php if($sale) : ?>
								<span><del><?php echo $currency; echo $price; ?></del> <?php echo $currency; echo $sale; ?></span>
							<?php elseif($price) : ?>
								<span><?php echo $currency; echo $price; ?></span>
							<?php endif; ?>

						</div>

					</div>

					<?php } ?>

				<?php endforeach ?>
			</div>
		</div>
	</section>
<?php } ?>


<?php do_action( 'woocommerce_after_single_product' ); ?>
