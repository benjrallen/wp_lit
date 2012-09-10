<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
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
		<script type="text/javascript">
			window.location.href="<?php bloginfo('url'); ?>";
		</script>
		<meta http-equiv="refresh" content="0;url=<?php bloginfo('url'); ?>">
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<title><?php
			/*
			 * Print the <title> tag based on what is being viewed.
			 * We filter the output of wp_title() a bit -- see
			 * boilerplate_filter_wp_title() in functions.php.
			 */
			wp_title( '|', true, 'right' );
		?></title>

    <meta name="author" content="Lit Motors, Inc.">
    <meta property="fb:app_id" content="156045794485389"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <?php /* ?>
		<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" /> 
    <?php */ ?>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="stylesheet" href="<?php bloginfo( 'template_directory' ); ?>/css/splash.css?v=015" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <!-- hello site5 -->
		<script type="text/javascript">
			Ease = new Object();
			Ease.Url = '<?php bloginfo( 'url' ); ?>';
			Ease.TemplateUrl = '<?php bloginfo('template_directory'); ?>';
			Ease.isFrontPage = <?php if(is_front_page()) { echo 'true'; }else{ echo 'false'; } ?>;
			Ease.wpVersion = '<?php echo trim(get_bloginfo("version")); ?>';
			Ease.postID = '<?php echo get_the_ID(); ?>';
		  <?php
		    if( isset($post->post_name) )
		      echo 'Ease.pageName = "'.$post->post_name.'";';
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
				{ test: window.JSON, nope: Ease.TemplateUrl+'/js/json2.js' },
				{ test: Modernizr.input.placeholder,
				  nope: Ease.TemplateUrl+'/js/placeholder.jquery.js'
				},
				{ load : Ease.TemplateUrl+'/js/jwplayer.js' },
				/* plugins.js & common.js for development */
				//{ load : Ease.TemplateUrl+'/js/plugins.js' },
				//{ load : Ease.TemplateUrl+'/js/common.js' },
				/* concatenate and optimize seperate script files for deployment using google closure compiler (compiler.jar) in js folder */
				{ load : Ease.TemplateUrl+'/js/theme.js?v=015' },
        { load: ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js' },
        { load: 'http://platform.twitter.com/widgets.js' },
        { load: "//connect.facebook.net/en_US/all.js#appId=266138276740381&xfbml=1" }
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
		<div id="fb-root"></div>
		
		<header id="header"role="banner">
  		<?php 
  		  if (is_front_page())
  		    echo '<a class="homeLink" href="'.home_url( '/home/' ).'"></a>'
  		?>
		  <div class="wrap">
  			<?php 
  			  if (is_front_page()) {
  			    echo '<h1>';
  			  } else { 
  			    echo '<h2>'; 
  			  }
  			?>
  			<a id="logo" href="<?php echo home_url( '/home/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
  			<?php if (is_front_page()) { echo '</h1>'; } else { echo '</h2>'; } ?>

    		<?php get_template_part('nav','primary'); ?>

		  </div>
		</header>
		
		
		<section id="content" role="main">
