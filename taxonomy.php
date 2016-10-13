<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */

get_header();

$header_text_class = "col-md-9";
$term_id = get_queried_object()->term_id;
$bgi_src = get_term_meta($term_id,'_pezestudio_header_bgimage',true);
$header_bgcolor = get_term_meta($term_id,'_pezestudio_header_bgcolor',true);
$header_height = get_term_meta($term_id,'_pezestudio_header_height',true);
$header_style_out = "";
if ( $bgi_src != '' ) {
	$bgi_id = pezestudio_get_attachment_id_from_url( $bgi_src );
	$bgi_meta = wp_get_attachment_metadata($bgi_id);
	$header_style_out .= "background-image: url('".$bgi_src."'); background-size: cover;";
}
if ( $header_bgcolor != '' ) {
	$header_style_out .= "background-color: ".$header_bgcolor.";";
}
$header_style_out = ( $header_style_out == '' ) ? '' : ' style="'.$header_style_out.'"';

if ( $header_height != '' ) {
	$js_out = "<script type='text/javascript'>var headerHeightPercent=".$header_height."</script>";
} else { $js_out = ''; }
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header<?php echo $header_style_out; ?> class="wrap">
				<div class="wrap-inner vspace">
				<div class="container-fluid">
				<div id="entry-header" class="row">
				<div class="<?php echo $header_text_class; ?>">
					<?php the_archive_title( '<h1 class="pez-bg main-tit">', '</h1>' );
					the_archive_description( '<div class="row"><div class="col-md-12 fp-slide-desc"><div class="pez-bg">', '</div></div></div>' ); ?>
				</div>
				</div>
				</div>
				</div>
				<?php echo $js_out; ?>
			</header><!-- .wrap -->

			<div id="entry-content" class="entry-content container-fluid">
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_navigation();

		else :
			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

			</div><!-- .entry-content -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
