<?php

  $vids = new WP_Query(array(
    'posts_per_page' => -1,
    'tax_query' => array(
      array(
      	'taxonomy' => 'post_format',
    		'field' => 'slug',
    		'terms' => array( 'post-format-video' )
      )
    )
  ));

  if( $vids->have_posts() ) : ?>
  
  <div id="carousel">
    <div class="wrap">
      <div class="nav back"></div>
      <div class="nav forward"></div>
      <div class="mask left"></div>
      <div class="mask right"></div>
      <div id="outer">
        <div id="inner">
        <?php 
          global $current_lit_video;
          
          while( $vids->have_posts() ) : $vids->the_post();
                    
            if( has_post_thumbnail() ){
              echo '<a href="'.get_permalink().'" title="'.get_the_title().'"'.
                      //' slug="'.$post->post_name.'"'.
                      ( $current_lit_video == $post->ID ? ' class="active"' : '' ).
                    '>'.
                      get_the_post_thumbnail($post->ID, 'video-thumb').
                   '</a>';
            }
  
          endwhile;
        ?>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>