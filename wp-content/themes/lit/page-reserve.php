<?php
/**
 * Template Name: Page - Reserve
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */

get_header('splash'); 

  //look for a evidence of a successful signup
  if( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'return' ){
    
    echo '<div id="actionReturn">Thank you for your reservation!  We will be in touch with you soon.</div>';
    
  }

?>	
	
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
  
  //noindex the private page
  if( $post->post_name == 'private' || $post->post_name == 'dentist-reserve' )
    echo '<meta name="robots" content="noindex,nofollow">';
  
  $bgImg = '';
  
  if( has_post_thumbnail() ){														
  	$thumbID = get_post_thumbnail_id($post->ID);
  	$thumbSrc = wp_get_attachment_image_src( $thumbID, 'full' );
    //$bgImg = ' style="background-image:url(\''.$thumbSrc[0].'\')"';
    $bgImg = ' style="background-image:url(\''.get_bloginfo('url').'/files/splash/reserve-bg.jpg\')"';
  }

?>

  <div id="grad" class="dark"></div>	
  <div class="grad none" <?php  echo $bgImg; ?>></div>
	<div class="wrap reserve">
  	<article id="reservePage" <?php post_class();?>>
	    
      <? get_template_part('reserve','form'); ?>

      <div class="clearfix"></div>
	  </article>
	</div>
<?php endwhile; endif; ?>
<?php get_footer(); ?>