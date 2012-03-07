<?php
/**
 * Template Name: Page - Contact
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
  	<article id="contactPage" <?php post_class(); echo $bgImg; ?>>	    
	    <div class="entry-content">
	      <header>
	        <h1 class="entry-title">Contact Us</h1>
	      </header>
	      <div class="entry-full">
	        <?php the_content(); ?>
        	<?php echo do_shortcode('[contact-form-7 id="400" title="Contact form 1"]'); ?>
	      </div>
	    </div>
      <div class="clearfix"</div>
	  </article>
	</div>

<?php endwhile; endif; ?>
<div class="clearfix"</div>
<?php get_footer(); ?>
<?php 
/*  HERE IS THE FORM CODE MARKUP IN CASE IT GETS LOST FROM DB ON LAUNCH

<div class="field">
	<label>Name:</label>[text* your-name]
</div>
<div class="field">
	<label>Email:</label>[email* your-email]
</div>
<div class="field">
	<label>Inquiry:</label>[textarea* your-message]
</div>

[submit "Submit"]

*/


/*  THE MESSAGE BODY FOR THE CONTACT FORM

From: [your-name] <[your-email]>

Message Body:
[your-message]

--
This mail is sent via contact form on Lit Motors, Inc. http://localhost:8888/wp_lit
*/
?>