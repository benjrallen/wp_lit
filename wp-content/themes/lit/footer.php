<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */
?>
		</section><!-- #main -->
						
		<footer id="footer" role="contentinfo">
				<div class="wrap">
					<?php
						$fDate = '&copy; 2011';
						if ( date('Y') != '2011' ) $fDate = $fDate.' - '.date('Y');
					?>
					<span class="foot-left"><span>Copyright <?php echo $fDate; ?></span><span class="hyph"> - </span><span><?php bloginfo('name'); ?>. </span><span>All Rights Reserved.</span></span>
					<span class="foot-right">Site by <a href="http://www.gurustugroup.com" id="guruLink" title="GuRuStu. Branding, Marketing & Web Design." target="_blank">GuRuStu Group</a></span>
					<div class="clearfix"></div>
				</div>
		</footer><!-- footer -->

		<?php get_template_part('nav','footer'); ?>

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */
	wp_footer();
?>
	</body>
</html>