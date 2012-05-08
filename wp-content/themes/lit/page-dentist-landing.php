<?php
/**
 * Template Name: Page - Dentist Landing
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */

get_header(); ?>	

<link href='http://fonts.googleapis.com/css?family=Didact+Gothic' rel='stylesheet' type='text/css'>

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
	<div class="wrap">
  	<article id="dentistLanding" <?php post_class(); echo $bgImg; ?>>
      <div class="box-wrap clearfix">
        <div class="two-col commute">
          <h2 class="box-title"><span><span>Are you happy with your commute?</span></span></h2>
          <div class="mask"></div>
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
          <h2 class="box-title"><span><span>We have the solution.</span></span></h2>
          <div class="mask"></div>
          <div class="pic slides">
            <div class="slide four" gid="4">no emissions,<br /> no fossil fuels</div>
            <div class="slide three" gid="3">Convenient<br /> parking</div>
            <div class="slide two" gid="2">Move easily<br /> through traffic</div>
            <div class="slide one" gid="1">220-mile range</div>
          </div>
          <div id="dControls"></div>
        </div>
      </div>
      
      <div class="links-wrap clearfix">
        <a href="http://litmotors.com/dentist-reserve/" class="reserve clearfix" title="Reserve your C-1 today.">
          <span class="big">I want one!</span>
          <span class="little">Pre-order your C-1 now</span>
          <span class="btn-reserve">Reserve a C-1 today.</span>
        </a>
        
        <div class="video">
          <a class="tech" href="http://litmotors.com/lit-motors-technology-video/" target="_blank" title="How our technology works">
            <span class="thumb"></span>
            <span class="text">How our <br />technology <br />works</span>
          </a>
          <a class="story" href="http://litmotors.com/story-of-the-c-1/" target="_blank" class="speech" title="Story of the C-1">
            <span class="thumb"></span>
            <span class="text">Story of <br />the C-1</span>
          </a>
          <a class="fortune" href="http://litmotors.com/danny-kim-fortune-brainstorm-green-2012/" target="_blank" class="speech" title="Lit Motors Founder/CEO Danny Kim">
            <span class="thumb"></span>
            <span class="text">Lit Motors <br />Founder/CEO <br />Danny Kim</span>
          </a>
        </div>
        
        <div class="press clearfix">
          <a href="http://money.cnn.com/video/technology/2011/10/11/ts_giro_car.cnnmoney/" target="_blank" class="cnn" title="Lit Motors on CNN">CNN</a>
          <a href="http://www.reuters.com/video/2012/02/12/c-1-motorcycle-car-seeks-traction-as-com?videoId=230043281" target="_blank" class="reuters" title="Lit Motors on Reuters">Reuters</a>
          <a href="http://www.greenbiz.com/blog/2012/03/19/can-lit-motor-c-1-succeed-where-segway-failed" target="_blank" class="greenbiz" title="Lit Motors on GreenBiz">GreenBiz.com</a>
          <a href="http://green.autoblog.com/2011/09/19/lit-motors-c1-enclosed-motorcycle-uses-flywheel-magic-not-train/" target="_blank" class="autobloggreen" title="Lit Motors on AutoBlog Green">AutoBlog Green</a>
          <a href="http://www.gizmag.com/lit-motors-c1-self-balancing-motorcycle/21002/" target="_blank" class="gizmag" title="Lit Motors on Gizmag">Gizmag</a>
        </div>
        
      </div>
	  </article>
	</div>

<div id="litTechVideo" class="popup video">
  <!--[if lte IE 9 ]>
  <object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='864' height='480' id='single1' name='single1'>
    <param name="movie" value="http://litmotors.com/wp-content/themes/lit/turntable/player.swf" />
  	<param name='allowfullscreen' value='true'>
  	<param name='allowscriptaccess' value='always'>
  	<param name='wmode' value='transparent'>
  	<param name='flashvars' value='file=http://litmotors.com/wp-content/themes/lit/techvideo/littech.mp4&image=http://litmotors.com/wp-content/themes/lit/techvideo/littech.jpg&controls=true&dock=false&autostart=false&quality=false&repeat=none'>
  	<embed
  		type='application/x-shockwave-flash'
  		id='single2'
  		name='single2'
  		src="http://litmotors.com/wp-content/themes/lit/turntable/player.swf"
  		width='864'
  		height='480'
  		bgcolor='undefined'
  		allowscriptaccess='always'
  		allowfullscreen='true'
  		wmode='transparent'
  		flashvars="controls=true&file=http://litmotors.com/wp-content/themes/lit/techvideo/littech.mp4&image=http://litmotors.com/wp-content/themes/lit/techvideo/littech.jpg" 
  	/>
  		<img alt="Lit Motors" src="http://litmotors.com/wp-content/themes/lit/techvideo/littech.jpg" width="640" height="360" title="Sorry, No video playback capabilities." />
  </object>
  <![endif]-->

  <!--[if (gt IE 9)|!(IE)]><!-->
  <video width="864" height="480" class="mejs-myskin" controls="controls" preload="auto" poster="http://litmotors.com/wp-content/themes/lit/techvideo/littech.jpg" >
     <source src="http://litmotors.com/wp-content/themes/lit/techvideo/littech.mp4" type="video/mp4"></source>
     <source src="http://litmotors.com/wp-content/themes/lit/techvideo/littech.webm" type="video/webm"></source>
     <source src="http://litmotors.com/wp-content/themes/lit/techvideo/littech.ogv" type="video/ogg"></source>
     <object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='864' height='480' id='single1' name='single1'>
       <param name="movie" value="http://litmotors.com/wp-content/themes/lit/turntable/player.swf" />
     	<param name='allowfullscreen' value='true'>
     	<param name='allowscriptaccess' value='always'>
     	<param name='wmode' value='transparent'>
     	<param name='flashvars' value='file=http://litmotors.com/wp-content/themes/lit/techvideo/littech.mp4&image=http://litmotors.com/wp-content/themes/lit/techvideo/littech.jpg&controls=true&dock=false&autostart=false&quality=false&repeat=none'>
     	<embed
     		type='application/x-shockwave-flash'
     		id='single2'
     		name='single2'
     		src="http://litmotors.com/wp-content/themes/lit/turntable/player.swf"
     		width='864'
     		height='480'
     		bgcolor='undefined'
     		allowscriptaccess='always'
     		allowfullscreen='true'
     		wmode='transparent'
     		flashvars="controls=true&file=http://litmotors.com/wp-content/themes/lit/techvideo/littech.mp4&image=http://litmotors.com/wp-content/themes/lit/techvideo/littech.jpg" 
     	/>
     		<img alt="Lit Motors" src="http://litmotors.com/wp-content/themes/lit/techvideo/littech.jpg" width="640" height="360" title="Sorry, No video playback capabilities." />
     </object>
  </video>
  <!--<![endif]-->
</div>

<div id="fortuneVideo" class="popup video">
  <!--[if lte IE 9 ]>
  <object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='864' height='480' id='single1' name='single1'>
    <param name="movie" value="http://litmotors.com/wp-content/themes/lit/turntable/player.swf" />
  	<param name='allowfullscreen' value='true'>
  	<param name='allowscriptaccess' value='always'>
  	<param name='wmode' value='transparent'>
  	<param name='flashvars' value='file=http://litmotors.com/wp-content/themes/lit/fortune/fortune2012.mp4&image=http://litmotors.com/wp-content/themes/lit/fortune/fortune2012.jpg&controls=true&dock=false&autostart=false&quality=false&repeat=none'>
  	<embed
  		type='application/x-shockwave-flash'
  		id='single2'
  		name='single2'
  		src="http://litmotors.com/wp-content/themes/lit/turntable/player.swf"
  		width='864'
  		height='480'
  		bgcolor='undefined'
  		allowscriptaccess='always'
  		allowfullscreen='true'
  		wmode='transparent'
  		flashvars="controls=true&file=http://litmotors.com/wp-content/themes/lit/fortune/fortune2012.mp4&image=http://litmotors.com/wp-content/themes/lit/fortune/fortune2012.jpg" 
  	/>
  		<img alt="Lit Motors" src="http://litmotors.com/wp-content/themes/lit/fortune/fortune2012.jpg" width="640" height="360" title="Sorry, No video playback capabilities." />
  </object>
  <![endif]-->

  <!--[if (gt IE 9)|!(IE)]><!-->
  <video width="864" height="480" class="mejs-myskin" controls="controls" preload="auto" poster="http://litmotors.com/wp-content/themes/lit/fortune/fortune2012.jpg" >
     <source src="http://litmotors.com/wp-content/themes/lit/fortune/fortune2012.mp4" type="video/mp4"></source>
     <source src="http://litmotors.com/wp-content/themes/lit/fortune/fortune2012.webm" type="video/webm"></source>
     <source src="http://litmotors.com/wp-content/themes/lit/fortune/fortune2012.ogv" type="video/ogg"></source>
     <object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='864' height='480' id='single1' name='single1'>
       <param name="movie" value="http://litmotors.com/wp-content/themes/lit/turntable/player.swf" />
     	<param name='allowfullscreen' value='true'>
     	<param name='allowscriptaccess' value='always'>
     	<param name='wmode' value='transparent'>
     	<param name='flashvars' value='file=http://litmotors.com/wp-content/themes/lit/fortune/fortune2012.mp4&image=http://litmotors.com/wp-content/themes/lit/fortune/fortune2012.jpg&controls=true&dock=false&autostart=false&quality=false&repeat=none'>
     	<embed
     		type='application/x-shockwave-flash'
     		id='single2'
     		name='single2'
     		src="http://litmotors.com/wp-content/themes/lit/turntable/player.swf"
     		width='864'
     		height='480'
     		bgcolor='undefined'
     		allowscriptaccess='always'
     		allowfullscreen='true'
     		wmode='transparent'
     		flashvars="controls=true&file=http://litmotors.com/wp-content/themes/lit/fortune/fortune2012.mp4&image=http://litmotors.com/wp-content/themes/lit/fortune/fortune2012.jpg" 
     	/>
     		<img alt="Lit Motors" src="http://litmotors.com/wp-content/themes/lit/fortune/fortune2012.jpg" width="640" height="360" title="Sorry, No video playback capabilities." />
     </object>
  </video>
  <!--<![endif]-->
</div>

<div id="c1Story" class="popup video">
  <!--[if lte IE 9 ]>
  <object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='864' height='480' id='single1' name='single1'>
    <param name="movie" value="http://litmotors.com/wp-content/themes/lit/turntable/player.swf" />
  	<param name='allowfullscreen' value='true'>
  	<param name='allowscriptaccess' value='always'>
  	<param name='wmode' value='transparent'>
  	<param name='flashvars' value='file=http://litmotors.com/wp-content/themes/lit/c1-story/c1-story.mp4&image=http://litmotors.com/wp-content/themes/lit/c1-story/c1-story.jpg&controls=true&dock=false&autostart=false&quality=false&repeat=none'>
  	<embed
  		type='application/x-shockwave-flash'
  		id='single2'
  		name='single2'
  		src="http://litmotors.com/wp-content/themes/lit/turntable/player.swf"
  		width='864'
  		height='480'
  		bgcolor='undefined'
  		allowscriptaccess='always'
  		allowfullscreen='true'
  		wmode='transparent'
  		flashvars="controls=true&file=http://litmotors.com/wp-content/themes/lit/c1-story/c1-story.mp4&image=http://litmotors.com/wp-content/themes/lit/c1-story/c1-story.jpg" 
  	/>
  		<img alt="Lit Motors" src="http://litmotors.com/wp-content/themes/lit/c1-story/c1-story.jpg" width="640" height="360" title="Sorry, No video playback capabilities." />
  </object>
  <![endif]-->

  <!--[if (gt IE 9)|!(IE)]><!-->
  <video width="864" height="480" class="mejs-myskin" controls="controls" preload="auto" poster="http://litmotors.com/wp-content/themes/lit/c1-story/c1-story.jpg" >
     <source src="http://litmotors.com/wp-content/themes/lit/c1-story/c1-story.mp4" type="video/mp4"></source>
     <source src="http://litmotors.com/wp-content/themes/lit/c1-story/c1-story.webm" type="video/webm"></source>
     <source src="http://litmotors.com/wp-content/themes/lit/c1-story/c1-story.ogv" type="video/ogg"></source>
     <object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='864' height='480' id='single1' name='single1'>
       <param name="movie" value="http://litmotors.com/wp-content/themes/lit/turntable/player.swf" />
     	<param name='allowfullscreen' value='true'>
     	<param name='allowscriptaccess' value='always'>
     	<param name='wmode' value='transparent'>
     	<param name='flashvars' value='file=http://litmotors.com/wp-content/themes/lit/c1-story/c1-story.mp4&image=http://litmotors.com/wp-content/themes/lit/c1-story/c1-story.jpg&controls=true&dock=false&autostart=false&quality=false&repeat=none'>
     	<embed
     		type='application/x-shockwave-flash'
     		id='single2'
     		name='single2'
     		src="http://litmotors.com/wp-content/themes/lit/turntable/player.swf"
     		width='864'
     		height='480'
     		bgcolor='undefined'
     		allowscriptaccess='always'
     		allowfullscreen='true'
     		wmode='transparent'
     		flashvars="controls=true&file=http://litmotors.com/wp-content/themes/lit/c1-story/c1-story.mp4&image=http://litmotors.com/wp-content/themes/lit/c1-story/c1-story.jpg" 
     	/>
     		<img alt="Lit Motors" src="http://litmotors.com/wp-content/themes/lit/c1-story/c1-story.jpg" width="640" height="360" title="Sorry, No video playback capabilities." />
     </object>
  </video>
  <!--<![endif]-->
</div>

<?php endwhile; endif; ?>
<div class="clearfix"></div>
<?php get_footer(); ?>