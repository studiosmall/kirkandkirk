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
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID ), 'single-post-thumbnail' );
			$lifestyle_image = get_field('lifestyle_image');
		?>

		<?php if($lifestyle_image['url']) { ?>
			<div class="lifestyle">
				<img src="<?php echo $lifestyle_image['url']; ?>" alt="<?php echo $lifestyle_image['title']; ?>">
			</div>
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
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
		add_action( 'woocommerce_after_single_product_summary', 'woocommerce_template_single_excerpt', 20 );

		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
		add_action( 'woocommerce_single_product_summary', 'the_content', 20 );

		do_action( 'woocommerce_single_product_summary' );

		?>
	</div>

</div>

</div>

<?php
	$review = get_field('product_review');
	$instagram = get_field('instagram', 'option');
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

	<?php if($instagram['instagram_images']) { ?>
		<section class="instagram">
			<div class="instagram__inner">
				<h3>Latest on Instagram</h3>

				<div class="feed">
					<?php foreach($instagram['instagram_images'] as $i): ?>
						<div class="feed__item">
							<a href="<?php echo $i['image_url'] ?>" target="_bank">
								<img src="<?php echo $i['image']['url'] ?>" alt="Kirk and Kirk – Instagram">
							</a>
						</div>
					<?php endforeach ?>
				</div>
			</div>
		</section>
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

?>

<?php if(($num_recently >= 3)) { ?>
	<section class="featured-products recently">
		<div class="featured-products__inner">

			<div class="title__inner">
				<h2>Recently viewed</h2>
			</div>

			<div class="featured-products__products slider">
			<?php foreach($recently as $product) : ?>

					<div class="featured-products__product">
						<?php
							//$product  = wc_get_product($product);
							$currency = get_woocommerce_currency_symbol();
							$price    = get_post_meta( get_the_ID(), '_regular_price', true);
							$sale     = get_post_meta( get_the_ID(), '_sale_price', true);

							$image 		= get_the_post_thumbnail_url($product, 'large');
							$link 		= get_permalink($product);
							$title 		= get_the_title($product);
							$fields  	= get_fields($product);

							$textarea  = $fields['textarea'];
							$colour    = $fields['product_colour'];

						?>

						<a class="link" href="<?php echo $link; ?>"></a>
						<img src="<?php echo $image; ?>"  alt="<?php echo $title; ?>">

						<div class="featured-products__meta" style="border-color:<?php echo $colour; ?>">
							<h1><?php echo $title; ?></h1>
							<?php if($sale) : ?>
								<span><del><?php echo $currency; echo $price; ?></del> <?php echo $currency; echo $sale; ?></span>
							<?php elseif($price) : ?>
								<span><?php echo $currency; echo $price; ?></span>
							<?php endif; ?>

						</div>

					</div>
				<?php endforeach ?>
			</div>
		</div>
	</section>
<?php } ?>


<?php do_action( 'woocommerce_after_single_product' ); ?>
