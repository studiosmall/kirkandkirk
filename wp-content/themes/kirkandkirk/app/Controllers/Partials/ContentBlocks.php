<?php

namespace App\Controllers\Partials;

trait ContentBlocks
{
  // get content_blocks
  function content_blocks() {
    global $post;

    $content_blocks = get_field('content_blocks');
    $content_block = array();

    if ($content_blocks) {

      foreach ($content_blocks as $c) {
        if ( isset($c) ){
          $block = $c['acf_fc_layout'];
          $fields = (array) $c[$block];
        } else {
          $fields = array();
        }
        switch ($c['acf_fc_layout']) {
          default:
            $content_block[] = return_component($c, $fields);
            break;
        }
      }
    }
    return $content_block;
  }
}

// return component array
function return_component($component,$fields){
    unset($component['component']);
    $component = array_merge($component, $fields);
    return $component;
}