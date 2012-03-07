<?php
/**
 * Template Name: Page - About
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
  <div id="grad"></div>	
	<div class="wrap">
  	<article id="aboutPage" <?php post_class(); echo $bgImg; ?>>
      <div id="aboutNav">
	      <?php echo ease_make_subpage_menu(); ?>
	    </div>
	    
	    <div class="entry-content">
	      <header>
	        <h1 class="entry-title"><? the_title(); ?></h1>
	      </header>
	      <div class="entry-full">
	        <?php the_content(); ?>
	      </div>
	    </div>
      <div class="clearfix"></div>
	  </article>
	</div>

<?php endwhile; endif; ?>
<div class="clearfix"></div>
<?php get_footer(); ?>