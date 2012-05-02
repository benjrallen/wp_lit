<?php
/**
 * Template Name: Page - Dentist Landing
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
  	<article id="dentistLanding" <?php post_class(); echo $bgImg; ?>>
      <div class="box-wrap clearfix">
        <div class="two-col commute">
          <h2 class="box-title">Are you happy with your commute?</h2>
          <div class="pic">
            <div class="car one">
              <span class="modal">Commute time</span>
            </div>
            <div class="car two">
              <span class="modal">Parking</span>
            </div>
            <div class="car three">
              <span class="modal">Gas prices</span>
            </div>
            <div class="car four">
              <span class="modal">Expensive<br /> alternative-fuel<br /> vehicles</span>
            </div>
          </div>
        </div>

        <div class="two-col solution" id="dentistRotate">
          <h2 class="box-title">We have the solution.</h2>
          <div class="pic">
            <h3 class="slide four" data-id="4">0 emissions, 0 fossil fuels</h3>
            <h3 class="slide three" data-id="3">Convenient parking</h3>
            <h3 class="slide two" data-id="2">Split lanes</h3>
            <h3 class="slide one" data-id="1">220-mile range</h3>
          </div>
          <div id="dControls"></div>
        </div>
      </div>
	  </article>
	</div>

<?php endwhile; endif; ?>
<div class="clearfix"></div>
<?php get_footer(); ?>