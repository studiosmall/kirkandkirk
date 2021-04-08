<?php

namespace App\Controllers\Partials;

trait AboutContentBlocks
{
  // get content_blocks
  function about_content_blocks() {
    global $post;

    $about_content_blocks = get_field('about_content_blocks');
    $about_content_block = array();

    if ($about_content_blocks) {

      foreach ($about_content_blocks as $c) {
        if ( isset($c) ){
          $block = $c['acf_fc_layout'];
          $fields = (array) $c[$block];
        } else {
          $fields = array();
        }
        switch ($c['acf_fc_layout']) {
          default:
            $about_content_block[] = return_component($c, $fields);
            break;
        }
      }
    }
    return $about_content_block;
  }
}

// // return component array
// function return_component($component,$fields){
//     unset($component['component']);
//     $component = array_merge($component, $fields);
//     return $component;
// }