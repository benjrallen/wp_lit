<?php
/**
 * Template Name: Page - About - How (gallery)
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */

get_header(); ?>	
	
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
  
  $bgImg = '';
  
  if( has_post_thumbnail() ){														
  	$thumbID = get_post_thumbnail_id($post->ID);
  	$thumbSrc = wp_get_attachment_image_src( $thumbID, 'full' );
    $bgImg = ' style="background-image:url(\''.$thumbSrc[0].'\')"';
  }

?>
  <div id="grad" class="dark"></div>	
	<div class="wrap">
  	<article id="aboutPage" <?php post_class(); echo $bgImg; ?>>
      <div id="aboutNav">
	      <?php echo ease_make_subpage_menu(); ?>
	    </div>
	    
	    <div id="rotatingGallery">

      <?php
      
      $attachments = get_children( array(
                      'post_parent' => $post->ID, 
                      'post_status' => 'inherit', 
                      'post_type' => 'attachment', 
                      'post_mime_type' => 'image', 
                      'order' => 'ASC', 
                      'orderby' => 'menu_order'
                    ));
      
      if(!empty($attachments)){
        
        echo '<div id="galleryJson">';

        $json = array();
        foreach($attachments as $id => $a){
          $full = wp_get_attachment_image_src($id, 'gallery');
          $aPost = get_post($id);
          $json[$id] = array(
            'full' => array(
              'src' => $full[0],
              'width' => $full[1],
              'height' => $full[2],
              'title' => $aPost->post_title,
              'desc' => $aPost->post_content
            )
    	    );
        }
      
        echo json_encode($json);
        unset($id);
        unset($a);
        unset($json);
        unset($attachments);
        
        echo '</div>';
      }
      
      ?>
      
      </div>	    
      
      <div class="clearfix"></div>
	  </article>
	</div>

<?php endwhile; endif; ?>
<div class="clearfix"></div>
<?php get_footer(); ?>