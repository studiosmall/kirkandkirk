<?php

namespace App\Controllers;

trait Articles
{
  // get content_blocks
	function articles() {

    $search = get_query_var('s') ? get_query_var('s') : '';
    $queried_object = get_queried_object();

    if ( $queried_object ) {
      $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 6,
        's' => $search,
        'cat' => $queried_object->term_id
      );
    } else {
      $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 6,
        's' => $search
      );
    }

    $articles = array();

    $articles['category'] = $queried_object->name ? $queried_object->name : 'All' ;

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
          // 'category_name' => $category_name,
          // 'category_slug' => $category_slug,
          // 'photographer' => get_field('photographer'),
          // 'fname' => get_the_author_meta('first_name'),
          // 'lname' => get_the_author_meta('last_name')
        );

        $articles['articles'][] = $article;

      }

      wp_reset_postdata();

    }

	  return $articles;
	}
}