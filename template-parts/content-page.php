<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */

$header_style_out = "";
$header_bgcolor = get_post_meta($post->ID,'_pezestudio_header_bgcolor',true);
if ( has_post_thumbnail() ) {
	$bgi_id = get_post_thumbnail_id( $post->ID );
	$bgi_src = wp_get_attachment_url($bgi_id);
	$bgi_meta = wp_get_attachment_metadata($bgi_id);
	$header_style_out .= "background-image: url('".$bgi_src."'); background-size: cover;";
}
if ( $header_bgcolor != '' ) {
	$header_style_out .= "background-color: ".$header_bgcolor.";";
}
$header_style_out = ( $header_style_out == '' ) ? '' : ' style="'.$header_style_out.'"';

$header_height = get_post_meta($post->ID,'_pezestudio_header_height',true);
if ($header_height != '' ) {
	$js_out = "<script type='text/javascript'>var headerHeightPercent=".$header_height."</script>";
} else { $js_out = ''; }
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header<?php echo $header_style_out; ?> class="entry-header wrap">
		<div class="wrap-inner vspace">
		<div class="container-fluid">
		<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<?php the_title( '<h1 class="pez-bg main-tit">', '</h1>' ); ?>
			<?php if ( get_edit_post_link() ) :
				edit_post_link('<span class="edit-link">'.esc_html__( 'Edit', '_s' ).'</span>');
			endif; ?>
		</div>
		</div>
		</div>
		</div>
	</header><!-- .entry-header -->

	<div class="entry-content container-fluid">
		<div class="row vspace">
		<div class="col-md-6 col-md-offset-3">
		<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', '_s' ),
				'after'  => '</div>',
			) );
		?>
		</div><!-- .col-xx-y -->
		</div><!-- .row -->
	</div><!-- .entry-content -->
	<?php echo $js_out; ?>

</article><!-- #post-## -->
