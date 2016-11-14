<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */

if ( has_post_thumbnail() ) {
	$img = get_the_post_thumbnail($post,'large',array( 'class' => 'img-responsive' ));
	$img_out = '
	<figure class="row">
		<div class="col-md-12">
		'.$img.'
		</div>
	</figure>
	';
} else { $img_out = ''; }
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('col-md-8 col-md-offset-2'); ?>>
	<?php echo $img_out; ?>
	<header class="entry-header row">
		<div class="col-md-12">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="pez-bg main-tit">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
		if ( get_edit_post_link() )
			edit_post_link('<span class="edit-link">'.esc_html__( 'Edit', '_s' ).'</span>'); ?>
		</div>
	</header><!-- .entry-header -->

	<div class="row vspace">
		<div class="entry-content col-md-9 col-md-push-3">
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', '_s' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', '_s' ),
				'after'  => '</div>',
			) );
		?>
		</div><!-- .entry-content -->

		<footer class="entry-footer col-md-3 col-md-pull-9">
			<?php _s_posted_on(); ?>
		</footer><!-- .entry-footer -->

	</div><!-- .row -->
</article><!-- #post-## -->
