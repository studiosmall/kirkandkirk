<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class FrontPage extends Controller
{
  use Partials\ContentBlocks;

  function type(){

    global $post;

    $type = array (
      'page_type' => get_field('page_type'),
      'user'      => wp_get_current_user(),
    );

    return $type;
  }
}
