<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Single extends Controller
{
  function article(){

    global $post;

    $article = array (
			'id'                => get_the_ID(),
			'title'             => get_the_title(),
			'image'             => get_the_post_thumbnail_url(),
			'cat'								=> get_the_category(),
			'colour'            => get_field('colour'),
			'textarea' 					=> get_field('textarea'),
			'readmore'  				=> get_field('read_more_text'),
			'images'  				  => get_field('image'),
    );

    return $article;
	}
}