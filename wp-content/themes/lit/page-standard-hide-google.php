<?php
/**
 * Template Name: Page - Standard no robots
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */

get_header(); ?>

<meta name="robots" content="noindex,nofollow">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
  
  $bgImg = '';
  
  if( has_post_thumbnail() ){														
  	$thumbID = get_post_thumbnail_id($post->ID);
  	$thumbSrc = wp_get_attachment_image_src( $thumbID, 'full' );
    $bgImg = ' style="background-image:url(\''.$thumbSrc[0].'\')"';
  }

?>
  <div id="grad"></div>	
	<div class="wrap clearfix">
  	<article id="construction" <?php post_class(); echo $bgImg; ?>>	    
	    <div class="entry-content clearfix">
        <?php /* ?>
	      <header>
	        <h1 class="entry-title"><? the_title(); ?></h1>
	      </header>
        <?php */ ?>
	      <div class="entry-full">
	        <?php the_content(); ?>
	      </div>
	    </div>
	  </article>
	</div>

<?php endwhile; endif; ?>
<?php get_footer(); ?>