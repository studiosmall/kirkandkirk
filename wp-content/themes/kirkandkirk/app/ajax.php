<?php
/**
 * Get more articles for filter and also more articles button
 */
function kirkandkirk_more_articles() {

	$offset = $_POST['offset'];
  $category = $_POST['category'];
  $search = $_POST['search'];

  if ( $category == 'all' ) {
    $args = array(
      'post_type' => 'post',
      'posts_per_page' => 6,
      'post_status' => 'publish',
      'offset' => $offset,
    );
  } else {
    $args = array(
      'post_type' => 'post',
      'posts_per_page' => 6,
      'post_status' => 'publish',
      'offset' => $offset,
      'category_name' => $category
    );
  }
  if ( $search ) {
    $args['s'] = $search;
  }

  $articles = array();

  $blog_query = new \WP_Query( $args );

  if ( $blog_query->have_posts() ) {

    while( $blog_query->have_posts() ) {

      $blog_query->the_post();

      $category = get_the_category();
      $category_name = $category ? $category[0]->name : 'Culture';
      $category_slug = $category ? $category[0]->slug: 'culture';

      $article = array(
        'author_url' => get_author_posts_url( get_the_author_meta( 'ID' )),
        'title' => get_the_title(),
        'slug' => get_the_permalink(),
        'image' => get_the_post_thumbnail_url(),
        'colour' => get_field('colour'),
        'border' => get_field('image_border'),
        'textarea' => get_field('textarea'),
        'readmore'  => get_field('read_more_text'),
      );
      ?>

          <div class="articles__card">
						<span class="articles__line" style="border-color: <?= $article['colour']; ?>"></span>
            <div class="articles__card--inner">
              <div class="articles__image <?= $article['border']; ?>">
                <img src="<?= $article['image']; ?>" alt="<?= $article['title']; ?>">
              </div>

              <h3>MEET</h3>
              <a href="<?= $article['slug']; ?>">
                <h2><?= $article['title']; ?></h2>
              </a>

              <div class="articles__text">

                <p>
                  <?= $article['textarea']; ?>
                </p>

                  <?php if($article['readmore']) : ?>

                    <a class="more" href="<?= $article['slug']; ?>">Read More</a>
                  <?php endif; ?>

              </div>
            </div>
					</div>

      <?php
    }

    wp_reset_postdata();

  } else {
    echo 'none';
  }

  die();
}
add_filter( 'wp_ajax_nopriv_kirkandkirk_more_articles', 'kirkandkirk_more_articles' );
add_filter( 'wp_ajax_kirkandkirk_more_articles', 'kirkandkirk_more_articles' );