<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the wordpress construct of pages
 * and that other 'pages' on your wordpress site will use a
 * different template.
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
  	<article id="construction" <?php post_class(); echo $bgImg; ?>>	    
	    <div class="entry-content">
        <?php /* ?>
	      <header>
	        <h1 class="entry-title"><? the_title(); ?></h1>
	      </header>
        <?php */ ?>
	      <div class="entry-full">
	        <?php the_content(); ?>
	      </div>
	    </div>
      <div class="clearfix"</div>
	  </article>
	</div>

<?php endwhile; endif; ?>
<div class="clearfix"</div>
<?php get_footer(); ?>