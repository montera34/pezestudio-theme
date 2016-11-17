<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */

?>

	</div><!-- #content -->

<?php if ( !is_home() && !is_front_page() ) { ?>
	<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="container vspace">
		<div class="row">
			<nav class="site-info col-md-8">
			<?php $location = "footer";
			if ( has_nav_menu( $location ) ) {
				$args = array(
					'theme_location'  => $location,
					'container' => false,
					'menu_id' => 'navbar-footer',
					'menu_class' => 'list-inline'
				);
				wp_nav_menu( $args );
			} ?>
			</nav><!-- .site-info -->
			<div id="credits" class="col-md-4"><p class="pull-right text-muted">Developped by <a href="https://montera34.com">Montera34</a>.</p></div>
		</div>
	</div>
	</footer><!-- #colophon -->
<?php } ?>

<?php wp_footer(); ?>

</body>
</html>
