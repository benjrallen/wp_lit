<?php

  $team = get_posts(array(
    'posts_per_page' => -1,
    'order' => 'ASC',
    'orderby' => 'menu_order title',
    'post_type' => 'lit_person'
  ));

?>
<nav id="team">
  <?php foreach( $team as $t ){
    echo '<a href="'.get_permalink($t->ID).'" title="'.apply_filters('the_title', $t->post_title).'" class="member'.( $t->ID == $post->ID ? ' active' : '' ).'">';
        if( has_post_thumbnail($t->ID) ){
          echo get_the_post_thumbnail($t->ID, 'person'); 
        }
    echo '</a>';
  } ?>
</nav>