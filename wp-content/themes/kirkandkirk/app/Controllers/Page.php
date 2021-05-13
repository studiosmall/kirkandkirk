<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Page extends Controller
{
  use Partials\ContentBlocks;
  use Partials\AboutContentBlocks;

  function type(){

    global $post;

    $type = array (
      'page_type' => get_field('page_type'),
      'user'      => wp_get_current_user(),
    );

    return $type;
  }

  function colour(){

    global $post;

    $colour = array (
      'bg' => get_field('colour'),
    );

    return $colour;
  }
}