<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Page extends Controller
{
  use Partials\ContentBlocks;
  use Partials\AboutContentBlocks;


  function colour(){

    global $post;

    $colour = array (
      'bg' => get_field('colour'),
    );

    return $colour;
  }
}