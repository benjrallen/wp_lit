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

    <video id="splash" width="720" height="480" class="mejs-myskin" autoplay="autoplay" controls="controls" preload="auto" poster="<?php bloginfo('template_directory'); ?>/turntable/timelapse.jpg" >
       <source src="<?php bloginfo('template_directory'); ?>/turntable/timelapse.mp4" type="video/mp4"></source>
       <source src="<?php bloginfo('template_directory'); ?>/turntable/timelapse.webm" type="video/webm"></source>
       <source src="<?php bloginfo('template_directory'); ?>/turntable/timelapse.ogv" type="video/ogg"></source>
 			<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='720' height='480' id='single1' name='single1'>
        <param name="movie" value="<?php bloginfo('template_directory'); ?>/turntable/player.swf" />
 				<param name='allowfullscreen' value='true'>
 				<param name='allowscriptaccess' value='always'>
 				<param name='wmode' value='transparent'>
 				<?php /* ?>
 				<param name='flashvars' value='file=<?php bloginfo('template_directory'); ?>/turntable/timelapse.mov&controlbar=none&dock=false&autostart=true&icons=false&quality=false&repeat=always'>
        <param name="flashvars" value="controls=true&file=<?php bloginfo('template_directory'); ?>/turntable/timelapse.mp4" />
        <?php */ ?>
				<param name='flashvars' value='file=<?php bloginfo('template_directory'); ?>/turntable/timelapse.mp4&controls=true&dock=false&autostart=true&quality=false&repeat=none'>
 				<embed
 					type='application/x-shockwave-flash'
 					id='single2'
 					name='single2'
 					src="<?php bloginfo('template_directory'); ?>/turntable/player.swf"
 					width='720'
 					height='480'
 					bgcolor='undefined'
 					allowscriptaccess='always'
 					allowfullscreen='true'
 					wmode='transparent'
 					<?php /* >
 					flashvars="file=<?php bloginfo('template_directory'); ?>/turntable/timelapse.mov&controlbar=none&dock=false&autostart=true&icons=false&quality=false&repeat=always"
          <?php */ ?>
          flashvars="controls=true&file=<?php bloginfo('template_directory'); ?>/turntable/timelapse.mp4" 
 				/>
      		<img alt="Lit Motors" src="<?php bloginfo('template_directory'); ?>/turntable/timelapse.jpg" width="640" height="360" title="Sorry, No video playback capabilities." />
 			</object>
     </video>

<?php /* ?>
		<source src="<?php echo site_url("/vid/2_turntable-web.mp4"); ?>" type="video/mp4"  /> 
		<source src="<?php echo site_url("/vid/2_turntable-web.webm"); ?>" type="video/webm" /> 
		<source src="<?php echo site_url("/vid/2_turntable-web.ogv"); ?>" type="video/ogv" /> 


   <video id="splash" width="960" height="500" loop="loop" autoplay="autoplay">
      <source src="<?php bloginfo('template_directory'); ?>/turntable/2_turntable-web.mp4" type="video/mp4"></source>
      <source src="<?php bloginfo('template_directory'); ?>/turntable/2_turntable-web.webm" type="video/webm"></source>
      <source src="<?php bloginfo('template_directory'); ?>/turntable/2_turntable-web.ogv" type="video/ogg"></source>
			<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='960' height='500' id='single1' name='single1'>
				<param name='movie' value="<?php bloginfo('template_directory'); ?>/turntable/player.swf">
				<param name='allowfullscreen' value='true'>
				<param name='allowscriptaccess' value='always'>
				<param name='wmode' value='transparent'>
				<param name='flashvars' value='file=<?php bloginfo('template_directory'); ?>/turntable/2_turntable-web.mp4&controlbar=none&dock=false&autostart=true&icons=false&quality=false&repeat=always'>
				<embed
					type='application/x-shockwave-flash'
					id='single2'
					name='single2'
					src="<?php bloginfo('template_directory'); ?>/turntable/player.swf"
					width='960'
					height='500'
					bgcolor='undefined'
					allowscriptaccess='always'
					allowfullscreen='true'
					wmode='transparent'
					flashvars="file=<?php bloginfo('template_directory'); ?>/turntable/2_turntable-web.mp4&controlbar=none&dock=false&autostart=true&icons=false&quality=false&repeat=always"
				/>
			</object>
    </video>
<?php */ ?>
  </div>
  <div class="clearfix"></div>

</article>

<?php get_footer(); ?>