<?php
/**
 * Template Name: Page - no templates, no robots
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */
?><!DOCTYPE html xmlns:fb="https://www.facebook.com/2008/fbml">
<!--[if lt IE 7 ]><html <?php language_attributes(); ?> class="no-js ie ie6 lte7 lte8 lte9"><![endif]-->
<!--[if IE 7 ]><html <?php language_attributes(); ?> class="no-js ie ie7 lte7 lte8 lte9"><![endif]-->
<!--[if IE 8 ]><html <?php language_attributes(); ?> class="no-js ie ie8 lte8 lte9"><![endif]-->
<!--[if IE 9 ]><html <?php language_attributes(); ?> class="no-js ie ie9 lte9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<title><?php wp_title( '|', true, 'right' ); ?></title>

    <meta name="robots" content="noindex,nofollow">

    <meta name="author" content="Lit Motors, Inc.">
    <?php /* ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" /> 
    <?php */ ?>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="stylesheet" href="<?php bloginfo( 'template_directory' ); ?>/css/single.css?v=015" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

		<script type="text/javascript">
			Ease = {};
			Ease.Url = '<?php bloginfo( 'url' ); ?>';
			Ease.TemplateUrl = '<?php bloginfo('template_directory'); ?>';
			Ease.isFrontPage = <?php if(is_front_page()) { echo 'true'; }else{ echo 'false'; } ?>;
			Ease.wpVersion = '<?php echo trim(get_bloginfo("version")); ?>';
		  <?php
		    if( isset($post->post_name) ){
		      echo 'Ease.pageName = "'.$post->post_name.'";';
		      echo 'Ease.pageTitle = "'.get_the_title( $post->ID ).'";';
          
        }
		  ?>
		</script>

    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/modernizr.js"></script>

    <?php
      /* use a different UA code for dev server and for actual site */
      $ga_ua = (  strpos($_SERVER["SERVER_NAME"], "localhost") !== false || 
                  strpos($_SERVER["SERVER_NAME"], "dev.benjrallen.com") !== false ?
                      'UA-31286635-1' :
                      'UA-25720006-1' );      
    ?>

		<script type="text/javascript">
      window._gaq = [['_setAccount','<?php echo $ga_ua; ?>'],['_trackPageview'],['_trackPageLoadTime']];

			Modernizr.load([
				{ load : ['//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'] },
				<?php /* ?>
				{ test: window.JSON, nope: Ease.TemplateUrl+'/js/json2.js' },
				{ test: Modernizr.input.placeholder,
				  nope: Ease.TemplateUrl+'/js/placeholder.jquery.js'
				},
				<?php */ ?>
				{ load : Ease.TemplateUrl+'/js/jwplayer.js' },
				/* plugins.js & common.js for development */
				/* concatenate and optimize seperate script files for deployment using google closure compiler (compiler.jar) in js folder */
				{ load : Ease.TemplateUrl+'/js/single.js?v=015' },
        { load: ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js' }
			]);
		</script>

		
<?php
		/* We add some JavaScript to pages with the comment form
		 * to support sites with threaded comments (when in use).
		 */
		//if ( is_singular() && get_option( 'thread_comments' ) )
		//	wp_enqueue_script( 'comment-reply' );

		/* Always have wp_head() just before the closing </head>
		 * tag of your theme, or you will break many plugins, which
		 * generally use this hook to add elements to <head> such
		 * as styles, scripts, and meta tags.
		 */
		wp_head();		
?>
	</head>
	<body <?php body_class(); ?>>		
    <section class="wrap">
      
      <div class="line"></div>
      
      <div class="content">
        <?php 
        
          if( have_posts() ) : while( have_posts() ) : the_post();
            the_content(); 
          endwhile; endif;
        
        ?>
      </div>
    
    </section>
  </body>
</html>