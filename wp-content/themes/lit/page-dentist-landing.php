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
              <span class="modal">Traffic gridlock</span>
            </div>
            <div class="car two">
              <span class="modal">Expensive, <br />scarce parking</span>
            </div>
            <div class="car three">
              <span class="modal">Skyrocketing<br /> gas prices</span>
            </div>
            <div class="car four">
              <span class="modal">Poor<br /> air quality</span>
            </div>
          </div>
        </div>

        <div class="two-col solution" id="dentistRotate">
          <h2 class="box-title">We have the solution.</h2>
          <div class="pic">
            <h3 class="slide four" data-id="4">no emissions,<br /> no fossil fuels</h3>
            <h3 class="slide three" data-id="3">Convenient<br /> parking</h3>
            <h3 class="slide two" data-id="2">Move easily<br /> through traffic</h3>
            <h3 class="slide one" data-id="1">220-mile range</h3>
          </div>
          <div id="dControls"></div>
        </div>
      </div>
      
      <div class="links-wrap clearfix">
        <div class="two-col press clearfix">
          <a class="watchhow" href="" target="_blank" title="Watch how our technology works!">Watch how our technology works!</a>
          
          <a href="http://money.cnn.com/video/technology/2011/10/11/ts_giro_car.cnnmoney/" target="_blank" class="cnn" title="Lit Motors on CNN">CNN</a>
          <?php /* ?><a href="http://gigaom.com/cleantech/green-overdrive-lit-motors-electric-folding-scooter/" target="_blank" class="gigaom" title="Lit Motors on GIGAOM">GIGAOM</a><?php */ ?>
          <a href="http://www.reuters.com/video/2012/02/12/c-1-motorcycle-car-seeks-traction-as-com?videoId=230043281" target="_blank" class="reuters" title="Lit Motors on Reuters">Reuters</a>
          <a href="http://www.greenbiz.com/blog/2012/03/19/can-lit-motor-c-1-succeed-where-segway-failed" target="_blank" class="greenbiz" title="Lit Motors on GreenBiz">GreenBiz.com</a>
          <a href="" target="_blank" class="wired" title="Lit Motors on Wired">Wired.com</a>
        </div>
        <div class="two-col call clearfix">
          <a href="" target="_blank" class="speech" title="Daniel Kim speaking at Fortune Brainstorm Green">Daniel Kim speaking at Fortune Brainstorm Green</a>
          <a href="http://litmotors.com/dentist-reserve/" class="reserve" title="Reserve your C-1 today.">Reserve a C-1 today.</a>
          <span class="want">I want one!</span>
        </div>
      </div>
	  </article>
	</div>

<?php endwhile; endif; ?>
<div class="clearfix"></div>
<?php get_footer(); ?>