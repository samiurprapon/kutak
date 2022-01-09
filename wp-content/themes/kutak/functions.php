<?php
/**
 * This will load all the functionality of surge.
 *
 * @ref readme.md
 */
require_once( trailingslashit( get_template_directory() ) . 'framework/surge.php' );
require_once( trailingslashit( get_template_directory() ) . 'ajax-functions.php' );


// sets max image width inserted into a post
if ( ! isset( $content_width ) ) {
	$content_width = 1048;
}


/**
 * Get the reading time of a post
 *
 * @return string
 */

if ( ! function_exists( 'read_time' ) ) {
	function read_time() {
		$word_count = str_word_count( strip_tags( get_the_content() ) );
		$ttr        = ( round( $word_count / 275 ) < 1 ) ? 1 : round( $word_count / 275 );

		if( $ttr > 1 ) {
			return $ttr . ' mins read';
		}

		return $ttr . ' min read';
	}
}

/**
 * This will limit/trim text by word and add eclipse(...) at the end of it
 *
 * @param $text
 * @param $limit
 *
 * @return string
 */

if ( ! function_exists( 'limit_text' ) ) {
	function limit_text( $text, $limit, $flag = true ) {
		$text = strip_tags( $text );
		if ( str_word_count( $text, 0 ) > $limit ) {
			$words        = explode( " ", $text );
			$trimmed_text = array_slice( $words, 0, $limit );

			if($flag){
				return implode( " ", $trimmed_text ) . ' ...';
			}
			return implode( " ", $trimmed_text );
		}

		return $text;
	}
}


/**
 * Get source of the article from CMP
 *
 * @return mixed
 */

if ( ! function_exists( 'nc_source' ) ) {
	function nc_source() {
		return get_post_meta( get_the_ID(), 'nc-source', true );
	}
}

/**
 * Get author of the article from CMP
 *
 * @return mixed
 */

if ( ! function_exists( 'nc_author' ) ) {
	function nc_author() {
		return get_post_meta( get_the_ID(), 'nc-author', true );
	}
}

/**
 * Get the featured image from NewsCred CDN
 *
 * @param $width
 * @param $height
 * @param int $quality
 */

if ( ! function_exists( 'nc_image' ) ) {
	function nc_image( $width, $height = null, $quality = 100 ) {

		//cdn image url
		$cdn_url = get_post_meta( get_the_ID(), 'nc-image', true );

		if ( $cdn_url ) {
			//return modified image
			return $height ? $cdn_url . '?width=' . $width . '&height=' . $height . '&q=' . $quality : $cdn_url . '?width=' . $width . '&q=' . $quality;
		}

		//add fallback image
		return get_placeholder();
	}
}

/**
 * Get Placeholder Image
 *
 * @return string
 */

if ( ! function_exists( 'get_placeholder' ) ) {
	function get_placeholder() {
		echo get_stylesheet_directory_uri() . '/assets/images/placeholder-image.png';
	}
}

/**
 * Add Default Email Sender
 *
 * @param $original_email_address
 *
 * @return string
 */
if ( ! function_exists( 'surge_custom_sender_email' ) ) {
	function surge_custom_sender_email( $original_email_address ) {
		return 'noreply@studioid.com';
	}
}

add_filter( 'wp_mail_from', 'surge_custom_sender_email' );


//define filtered category
define( 'FILTER_CATEGORY', [
	'home-section-1',
	'home-section-2',
	'home-section-3',
	'uncategorized',
] );


/**
 * The entry category
 *
 * @param $post_id
 *
 */

if ( ! function_exists( 'the_article_category' ) ) {
	function the_article_category( $post_id ) {
		$categories = get_the_category( $post_id );
		$category   = null;

		foreach ( $categories as $cat ) {
			if ( ! in_array( $cat->slug, FILTER_CATEGORY, true ) ) {
				$category_parent = get_ancestors( $cat->term_id, 'category' );
				$category        = ( ! empty( $category_parent ) ) ? get_category( end( $category_parent ) ) : $cat;
				break;
			}
		}

		if ( $category ) {
			echo '<a class="category" href="' . get_category_link( $category ) . '">' . $category->name . '</a>';
		} else {
			echo '<span class="category">No category</span>';
		}
	}
}

/**
 * This will return the menu as li
 * @param $menu
 *
 * @return false|string|void
 */

if ( ! file_exists( 'surge_custom_menu' ) ) {
	function surge_custom_menu( $menu ) {
		wp_nav_menu( [
			'menu' => $menu,
			'container' => ''
		] );
	}
}


/**
 * Primary menu
 * call surge_primary_menu();
 *
 * Make sure to check the "Navigation Primary" checkbox in menu section
 */

if ( ! function_exists( 'surge_primary_menu' ) ) {
	function surge_primary_menu() {
		$menu_name = 'nav-primary';
		if ( has_nav_menu( $menu_name ) ) {
			wp_nav_menu( [
					'menu'            => $menu_name,
					'theme_location'  => $menu_name,
					'depth'           => 1,
					'container_class' => 'nav-navbar',
					'fallback_cb'     => false,
				]
			);
		} else {
			echo 'Please set up your menu';
		}
	}
}

/**
 * @param $url
 *
 * @return mixed
 */
function remove_http($url) {
	$disallowed = array('http://', 'https://');
	foreach($disallowed as $d) {
		if(strpos($url, $d) === 0) {
			return str_replace($d, '', $url);
		}
	}
	return $url;
}

/**
 * Get video url of the article from CMP
 *
 * @return mixed
 */

if ( ! function_exists( 'nc_video' ) ) {
	function nc_video() {
		$video = get_post_meta( get_the_ID(), 'Video URL', true );

		if ( strpos( $video, 'youtu' ) !== false ) {

			if ( strpos( $video, 'youtu.be' ) !== false ) {
				$video = remove_http( $video );
				rtrim( $video, '/' );
				$video = 'https://www.youtube.com/embed/' . explode( '/', $video )[1];
			}
			if ( strpos( $video, 'watch?v' ) !== false ) {
				$video = remove_http( $video );
				rtrim( $video, '/' );
				$video = 'https://www.youtube.com/embed/' . explode( '?v=', $video )[1];
			}
		}

		return $video;
	}
}