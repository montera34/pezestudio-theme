<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package _s
 */

function pezestudio_get_post_nav_links($post) {

	$link_prev = get_previous_post_link( '<span class="post-nav-label"><i class="fa fa-chevron-left" aria-hidden="true"></i> '.__("Previous post","_s").'</span> %link', '%title', false, '', 'category' );
	$link_next = get_next_post_link( '<span class="post-nav-label">'.__("Next post","_s").' <i class="fa fa-chevron-right" aria-hidden="true"></i></span> %link', '%title', false, '', 'category' );

	$links_out = '';
	$link_class = ( $link_prev == '' || $link_next == '' ) ? "col-md-8 col-md-offset-2" :"col-md-4";
	if ( $link_prev != '' ) {
		$links_out .= '<div class="post-nav '.$link_class.' col-md-offset-2">'.$link_prev.'</div>';
	}
	if ( $link_next != '' ) {
		$links_out .= '<div class="post-nav '.$link_class.' text-right">'.$link_next.'</div>';
	}

	return $links_out;
}

if ( ! function_exists( '_s_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function _s_posted_on() {

	$meta_out = '<ul class="list-unstyled">';

	// PUBLISHED TIME
	$time_string = '<li><i class="fa fa-asterisk" aria-hidden="true"></i> <time class="entry-date published updated" datetime="%1$s">%2$s</time></li>';
	$meta_out .= sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	// MODIFIED TIME
	//if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
	//	$update_string = '<li><time class="updated" datetime="%1$s">%2$s</time></li>';
	//	$update_string = sprintf( $update_string,
	//		esc_attr( get_the_modified_date( 'c' ) ),
	//		esc_html( get_the_modified_date() )
	//	);
	//} else { $update_string = ''; }

	// AUTHOR
	$meta_out .= '<li><i class="fa fa-user" aria-hidden="true"></i> <span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span></li>';

	// PERMALINK
	$meta_out .= '<li><i class="fa fa-link" aria-hidden="true"></i> <a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . __('Permalink','_s') . '</a></li>';

	// CATEGORIES
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', '_s' ) );
		if ( $categories_list && _s_categorized_blog() ) {
			$meta_out .= '<li class="cat-links"><i class="fa fa-folder" aria-hidden="true"></i> ' .$categories_list. '</li>';
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', '_s' ) );
		if ( $tags_list ) {
			$meta_out .= '<li class="tags-links"><i class="fa fa-tag" aria-hidden="true"></i> ' .$tags_list. '</li>';
		}
	}

	$meta_out .= '</ul>';
	echo $meta_out;

}
endif;


/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function _s_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( '_s_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( '_s_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so _s_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so _s_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in _s_categorized_blog.
 */
function _s_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( '_s_categories' );
}
add_action( 'edit_category', '_s_category_transient_flusher' );
add_action( 'save_post',     '_s_category_transient_flusher' );
