<section id="homeWrap">
  <div id="homeRotate">
  <?php

    $post_type = 'lit_banner';

    //do a query for the banner posts
  	$ban = get_posts(array(
  	 'posts_per_page'=> -1,
  	 'order' => 'DESC',
  	 'orderby' => 'menu_order',
  	 'post_type' => $post_type
  	));
		
    if ( !empty($ban) ) {
  		echo '<div class="slides">';

      foreach( $ban as $b ){
      
  			if (  class_exists('MultiPostThumbnails') 
  			      && MultiPostThumbnails::has_post_thumbnail($post_type, 'fp-banner', $b->ID)
  			      && MultiPostThumbnails::has_post_thumbnail($post_type, 'fp-thumb', $b->ID)) {						
				
  				$banID    = MultiPostThumbnails::get_post_thumbnail_id( $post_type, 'fp-banner', $b->ID );
  				$thumbID  = MultiPostThumbnails::get_post_thumbnail_id( $post_type, 'fp-thumb', $b->ID );
				
  				/** wp_get_attachment_image_src( id, size )
  				 *  returns:  array(
  				 *              0 => str: url,
  				 *              1 => int: width,
  				 *              2 => int: height
  				 *            )
  				 */
  				//get images
  				$full = wp_get_attachment_image_src( $banID, 'banner' );
  				$thumb = wp_get_attachment_image_src( $thumbID, 'banner-thumb' );
				
  				$base_width = 980;
  				$left = floor( ($base_width - $full[1]) / 2 );
				
  				echo '<div class="slide" gid="'.$b->ID.'" thumb=\''.json_encode($thumb).'\'>';
  				  echo '<img src="'.$full[0].'" height="'.$full[2].'" width="'.$full[1].'" style="left:'.$left.'px;" />';
  				  echo '<div class="description">';
    					echo '<span class="title">'.apply_filters('the_title', $b->post_title).'</span>';
    					echo '<span class="caption">'.apply_filters('the_content', $b->post_content).'</span>';
  					  echo '<div class="clearfix"></div>';
    				echo '</div>';				
  				echo '</div>';																		
  			}      
      }
      echo '</div>';
    }
  ?>

  	<div class="clearfix"></div>
  </div>
  <div id="controlOut"><div id="controlWrap"></div></div>
</section>