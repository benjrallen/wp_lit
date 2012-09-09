<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query. 
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */

get_header(); ?>
oh hello!
			<?php
			/* Run the loop to output the posts.
			 * If you want to overload this in a child theme then include a file
			 * called loop-index.php and that will be used instead.
			 */
			 //get_template_part( 'loop', 'index' );
			?>

<?php /* Sidebar before rotator on owasso */ ?>


<article id="front-page-entry" <?php post_class(); ?>>

<?php //if ( have_posts() ) : while( have_posts() ) : the_post(); ?>

<?php //the_content(); ?>

<?php //endwhile; endif; ?>

<?php 
  if (is_front_page())
    echo '<a class="homeLink" href="'.home_url( '/home/' ).'"></a>'
?>


  <div class="wrap">
		<?php 
		  if (is_front_page())
		    echo '<a class="homeLink" href="'.home_url( '/home/' ).'"></a>'
		?>

    <!--[if lte IE 9 ]>
    <object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='848' height='480' id='single1' name='single1'>
      <param name="movie" value="http://litmotors.com/wp-content/themes/lit/turntable/player.swf" />
    	<param name='allowfullscreen' value='true'>
    	<param name='allowscriptaccess' value='always'>
    	<param name='wmode' value='transparent'>
    	<param name='flashvars' value='file=http://litmotors.com/wp-content/themes/lit/driving/driving.mp4&image=http://litmotors.com/wp-content/themes/lit/driving/driving.jpg&controls=true&dock=false&autostart=false&quality=false&repeat=none'>
    	<embed
    		type='application/x-shockwave-flash'
    		id='single2'
    		name='single2'
    		src="http://litmotors.com/wp-content/themes/lit/turntable/player.swf"
    		width='848'
    		height='480'
    		bgcolor='undefined'
    		allowscriptaccess='always'
    		allowfullscreen='true'
    		wmode='transparent'
    		flashvars="controls=true&file=http://litmotors.com/wp-content/themes/lit/driving/driving.mp4&image=http://litmotors.com/wp-content/themes/lit/driving/driving.jpg" 
    	/>
    		<img alt="Lit Motors" src="http://litmotors.com/wp-content/themes/lit/driving/driving.jpg" width="640" height="360" title="Sorry, No video playback capabilities." />
    </object>
    <![endif]-->

    <!--[if (gt IE 9)|!(IE)]><!-->
    <video width="848" height="480" class="mejs-myskin" controls="controls" preload="auto" poster="http://litmotors.com/wp-content/themes/lit/driving/driving.jpg" >
       <source src="http://litmotors.com/wp-content/themes/lit/driving/driving.mp4" type="video/mp4"></source>
       <source src="http://litmotors.com/wp-content/themes/lit/driving/driving.webm" type="video/webm"></source>
       <source src="http://litmotors.com/wp-content/themes/lit/driving/driving.ogv" type="video/ogg"></source>
       <object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='848' height='480' id='single1' name='single1'>
         <param name="movie" value="http://litmotors.com/wp-content/themes/lit/turntable/player.swf" />
       	<param name='allowfullscreen' value='true'>
       	<param name='allowscriptaccess' value='always'>
       	<param name='wmode' value='transparent'>
       	<param name='flashvars' value='file=http://litmotors.com/wp-content/themes/lit/driving/driving.mp4&image=http://litmotors.com/wp-content/themes/lit/driving/driving.jpg&controls=true&dock=false&autostart=false&quality=false&repeat=none'>
       	<embed
       		type='application/x-shockwave-flash'
       		id='single2'
       		name='single2'
       		src="http://litmotors.com/wp-content/themes/lit/turntable/player.swf"
       		width='848'
       		height='480'
       		bgcolor='undefined'
       		allowscriptaccess='always'
       		allowfullscreen='true'
       		wmode='transparent'
       		flashvars="controls=true&file=http://litmotors.com/wp-content/themes/lit/driving/driving.mp4&image=http://litmotors.com/wp-content/themes/lit/driving/driving.jpg" 
       	/>
       		<img alt="Lit Motors" src="http://litmotors.com/wp-content/themes/lit/driving/driving.jpg" width="640" height="360" title="Sorry, No video playback capabilities." />
       </object>
    </video>
    <!--<![endif]-->

  </div>
  <div class="clearfix"></div>

</article>

<?php get_footer(); ?>