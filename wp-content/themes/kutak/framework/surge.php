<?php
/**
 * All default functionality of surge.
 * @ref readme.md
 *
 * @author Rhythm Shahriar <hello@rhy.io>
 * @link http://rhy.io
 * @version 1.0.0
 */

/**
 *  Sets up theme defaults and registers support for various WordPress features.
 *
 * @ref https://codex.wordpress.org/Plugin_API/Action_Reference/after_setup_theme
 */

if ( ! function_exists( 'surge_theme_setup' ) ) {
	add_action( 'after_setup_theme', 'surge_theme_setup' );

	function surge_theme_setup() {
		#Add theme support for Automatic Feed Links
		add_theme_support( 'automatic-feed-links' );

		#Add theme support for Featured Images
		add_theme_support( 'post-thumbnails' );

		#Add theme support for document title tag
		add_theme_support( 'title-tag' );

		#Add theme support for HTML5 Semantic Markup
		add_theme_support( 'html5', [ 'search-form', 'caption' ] );
	}
}

/**
 * Enqueues stylesheet with Wordpress and adds version number that is a timestamp of the file modified date.
 * This should ensure that users always have the current version of the file, and that the CDN is properly updated.
 *
 * @param string $name The name of the stylesheet
 * @param $path
 * @param bool $dependencies
 * @param string $media
 */

if ( ! function_exists( 'surge_versioned_style' ) ) {
	function surge_versioned_style( $name, $path, $dependencies = false, $media = 'all' ) {
		if ( ! is_admin() ) {
			wp_enqueue_style( $name, get_template_directory_uri() . $path, $dependencies, filemtime( get_template_directory() . $path ), $media );
		}
	}
}

/**
 * Enqueues script with Wordpress and adds version number that is a timestamp of the file modified date.
 * This should ensure that users always have the current version of the script, and that the CDN is properly updated.
 *
 * @param string $name The name of the script
 * @param $path
 * @param bool $dependencies
 * @param bool $in_footer
 */

if ( ! function_exists( 'surge_versioned_script' ) ) {
	function surge_versioned_script( $name, $path, $dependencies = false, $in_footer = false ) {
		if ( ! is_admin() ) {
			wp_enqueue_script( $name, get_template_directory_uri() . $path, $dependencies, filemtime( get_template_directory() . $path ), $in_footer );
		}
	}
}

/**
 * check the hub environment local or production
 *
 * @return bool
 */
function is_production() {
	return file_exists( get_template_directory() . '/assets/bundle.css' );
}

// load bundle.js
surge_versioned_script( 'bundle', '/assets/bundle.js', array( 'jquery' ), true );

function register_styles() {
	wp_enqueue_style( 'google-font', 'https://fonts.googleapis.com/css2?family=Karla:wght@400;500&family=Oswald:wght@400;500;600;700&display=swap');
	wp_enqueue_style( 'font-awesome', 'https://use.fontawesome.com/releases/v5.0.13/css/all.css');
}

add_action( 'wp_enqueue_scripts', 'register_styles' );

// load main.css in production
if ( is_production() ) {
	surge_versioned_style( 'bundle', '/assets/bundle.css' );
}

/**
 * Get images from assets folder
 *
 * @param $file_name
 *
 * @return string
 */

if ( ! function_exists( 'image_url' ) ) {
	function image_url( $file_name ) {
		echo get_stylesheet_directory_uri() . "/assets/images/{$file_name}";
	}
}

if ( ! function_exists( ' get_current_year' ) ) {
	function get_current_year() {
		return date( 'Y' );
	}
}


/**
 * Remove yoast plugin canonical link from single
 *
 * @param $canonical
 *
 * @return bool
 *
 * @ref https://yoast.com/wordpress/plugins/seo/api/
 */

if ( ! function_exists( 'wpseo_canonical_exclude' ) ) {
	function wpseo_canonical_exclude( $canonical ) {
		global $post;
		if ( is_single() ) {
			$canonical = false;
		}

		return $canonical;
	}

	add_filter( 'wpseo_canonical', 'wpseo_canonical_exclude' );
}

/* Enforce HTTP Open Graph URLs in Yoast SEO
 *
 * Update og:url
 */

if ( ! function_exists( 'wpseo_change_ogurl' ) ) {
	function wpseo_change_ogurl( $url ) {
		return ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	}
	add_filter( 'wpseo_opengraph_url', 'wpseo_change_ogurl' );
}

/**
 * Get the canonical link either from WordPress permalink or from custom field
 *
 * @param $canonical
 *
 * @return false|mixed|string
 *
 * @ref https://yoast.com/wordpress/plugins/seo/api/
 */

if ( ! function_exists( 'wpseo_canonical_overwrite' ) ) {
	function wpseo_canonical_overwrite( $canonical ) {
		global $post;
		if ( is_single() ) {
			$nc_link = get_post_meta( get_the_ID(), 'nc-link', true );
			if ( ! empty( $nc_link ) ) {
				return $nc_link;
			} else {
				return get_the_permalink();
			}
		}

		return $canonical;
	}

	add_filter( 'wpseo_canonical', 'wpseo_canonical_overwrite' );
}


/**
 * This will generate menu links in WordPress way
 *
 * Class Surge_Walker_Nav_Menu
 */
class Surge_Walker_Nav_Menu extends Walker_Nav_Menu {

	/**
	 * Starts the list before the elements are added.
	 *
	 * Adds classes to the unordered list sub-menus.
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param array $args An array of arguments. @see wp_nav_menu()
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		// Depth-dependent classes.
		$indent        = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
		$display_depth = ( $depth + 1 ); // because it counts the first submenu as 0
		$classes       = array(
			'sub-menu',
			( $display_depth % 2 ? 'menu-odd' : 'menu-even' ),
			( $display_depth >= 2 ? 'sub-sub-menu' : '' ),
			'menu-depth-' . $display_depth
		);
		$class_names   = implode( ' ', $classes );

		// Build HTML for output.
		$output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
	}

	/**
	 * Start the element output.
	 *
	 * Adds main/sub-classes to the list items and links.
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param array $args An array of arguments. @see wp_nav_menu()
	 * @param int $id Current item ID.
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $wp_query;
		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

		// Depth-dependent classes.
		$depth_classes     = array(
			( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
			( $depth >= 2 ? 'sub-sub-menu-item' : '' ),
			( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
			'menu-item-depth-' . $depth
		);
		$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

		// Passed classes.
		$classes     = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

		// Build HTML.
		$output .= $indent . '<li class="' . $depth_class_names . ' ' . $class_names . '">';

		// Link attributes.
		$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';
		$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

		// Build HTML output and pass through the proper filter.
		$item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
			$args->before,
			$attributes,
			$args->link_before,
			apply_filters( 'the_title', $item->title, $item->ID ),
			$args->link_after,
			$args->after
		);
		$output      .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

/**
 * Register Nav Menu
 * It will add "Navigation Primary" checkbox in menu section
 */
function register_primary_menu() {
	register_nav_menu( 'nav-primary', __( 'Navigation Primary' ) );
}

add_filter( 'init', 'register_primary_menu' );

/**
 * This will reduce the size of the images and optimize all jpeg, jpg, png, gif, svg while upload or attach
 * in Wp Editor or in Media library as well as it will optimize all other sizes of the image in upload
 * directory.
 *
 * @max-size Maximum size of an image is 2400px
 *
 * @ref https://secure.php.net/manual/ru/book.imagick.php
 * @ref https://pngquant.org/
 */

// set the maximum size of an image
if ( ! defined( 'MAX_IMAGE_SIZE' ) ) {
	define( 'MAX_IMAGE_SIZE', 2400 );
}

// set Imagick as default mage lib
add_filter( 'wp_image_editors', function ( $implementations ) {
	return array_merge( [ 'WP_Image_Editor_Imagick' ], (array) $implementations );
}, 999 );

// set quality for images
add_filter( 'wp_editor_set_quality', function ( $quality, $mime_type ) {
	if ( 'image/jpeg' == $mime_type ) {
		$quality = 80;
	}

	return $quality;
}, 999, 2 );

// create pngcrush action
add_action( 'pngcrush', function ( $filename ) {
	$filename = escapeshellarg( $filename );
	if ( false === ( $command = wp_cache_get( 'pngcrush-bin' ) ) ) {
		$command = @exec( 'which pngquant' );
		if ( $command ) {
			wp_cache_set( 'pngcrush-bin', $command, '', DAY_IN_SECONDS );
		} else {
			$command = false;
		}
	}
	if ( ! $command ) {
		return false;
	}
	$command = escapeshellarg( $command );
	exec( "$command --quality=65-80 $filename --output $filename --force" );

	return true;
} );

// compress original image
add_filter( 'wp_handle_upload', function ( $args ) {
	if ( 'image/jpeg' == $args['type'] || 'image/png' == $args['type'] ) {
		$img = wp_get_image_editor( $args['file'] );
		if ( ! is_wp_error( $img ) ) {
			$size = $img->get_size();

			if ( $size['width'] > MAX_IMAGE_SIZE || $size['height'] > MAX_IMAGE_SIZE ) {
				$img->resize( MAX_IMAGE_SIZE, MAX_IMAGE_SIZE );
			}

			$img->save( $args['file'] );
		}
	}

	if ( 'image/png' == $args['type'] ) {
		do_action( 'pngcrush', $args['file'] );
	}

	return $args;
}, 999 );

// compress image sizes
add_filter( 'wp_generate_attachment_metadata', function ( $metadata ) {
	$uploads = wp_upload_dir();
	$dir     = dirname( $uploads['basedir'] . DIRECTORY_SEPARATOR . $metadata['file'] );
	foreach ( $metadata['sizes'] as $size ) {
		if ( 'image/png' == $size['mime-type'] ) {
			$filename = $dir . DIRECTORY_SEPARATOR . $size['file'];
			do_action( 'pngcrush', $filename );
		}
	}

	return $metadata;
}, 999 );


/**
 * Optimize the images in content those are coming from NewsCred Image CDN
 * This will check the image dimension, if the size is already define then it will use the same dimension
 * image from NewsCred CDN otherwise it will call the content width size to make sure the max width of the
 * images.
 *
 * @author Rhythm Shahriar
 * @link http://rhy.io
 * @version 1.0.0
 * @deprecated 1.0.0
 */

if ( ! function_exists( 'surge_optimize_content_image' ) ) {
	function surge_optimize_content_image( $content ) {

		//find all the images of newscred cdn
		preg_match_all( '/<img.*src=".*image.*.newscred.com[^"].*>/i', $content, $all_cdn_images );

		//get the global content max width
		global $content_width;

		//iterate all images
		foreach ( $all_cdn_images[0] as $image ) {


			//get the image width
			preg_match( '/(width)=("[^"]*")/i', $image, $width );

			//default image size
			$image_width = $content_width;

			//if the width exist
			if ( isset( $width[2] ) ) {
				//if the width is less than container width
				//use the min width
				$img_width = round( trim( $width[2], '"' ) );
				if ( $img_width < $content_width ) {
					//define the existing width
					$image_width = $img_width;
				}
			}

			//get the source of the image
			preg_match( '/src=".*image.*.newscred.com[^"]*/i', $image, $src );


			$images_src = [];
			foreach ($src as $url){
				$size = getimagesize(substr($url, 5));
				if($size['mime'] !=  "image/gif"){
					array_push($images_src, $url);
				}
			}

			$src = $images_src;

			//check the cdn url if it already has width query
			if ( ! strpos( '?width=', $src[0] ) ) {
				//add the content max width
				$content = str_replace( $src[0], $src[0] . '?width=' . $image_width, $content );
			}
		}

		return $content;
	}

	add_filter( 'the_content', 'surge_optimize_content_image' );
}

/**
 * Disable the emoji's
 */
function surge_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'surge_disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'surge_disable_emojis_remove_dns_prefetch', 10, 2 );
}

add_action( 'init', 'surge_disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 *
 * @param array $plugins
 *
 * @return array Difference betwen the two arrays
 */
function surge_disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 *
 * @return array Difference betwen the two arrays.
 */
function surge_disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {
		/** This filter is documented in wp-includes/formatting.php */
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

		$urls = array_diff( $urls, array( $emoji_svg_url ) );
	}

	return $urls;
}


/**
 * Remove id and class from menu
 *
 * @param $var
 *
 * @return array|string
 */

if ( ! function_exists( 'surge_remove_attr_filter' ) ) {
	function surge_remove_attr_filter( $var ) {
		return is_array( $var ) ? array_intersect( $var, [ 'current-menu-item' ] ) : '';
	}
}

add_filter( 'nav_menu_item_id', 'surge_remove_attr_filter', 100, 1 );

/**
 * Surge Remove Unused header links
 * from loading on the frontend
 */

if ( ! function_exists( 'surge_remove_wp_block_library_css' ) ) {
	function surge_remove_wp_block_library_css() {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
		wp_dequeue_style( 'wc-block-style' );
	}
}

add_action( 'wp_enqueue_scripts', 'surge_remove_wp_block_library_css', 100 );

remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
remove_action('template_redirect', 'rest_output_link_header', 11, 0);

remove_action ('wp_head', 'rsd_link');
remove_action( 'wp_head', 'wlwmanifest_link');
remove_action( 'wp_head', 'wp_shortlink_wp_head');


/**
 * Remove wp embed from home
 */
function surge_remove_wp_embed_home() {
	if (!is_admin() && !is_home()) {
		wp_deregister_script('wp-embed');
	}
}
add_action('init', 'surge_remove_wp_embed_home');

/**
 * Surge Remove Feeds
 */
function surge_disable_feed() {
	wp_die( __( 'No feed available, please visit the <a href="' . esc_url( home_url( '/' ) ) . '">homepage</a>.' ) );
}

add_action( 'do_feed', 'surge_disable_feed', 1 );
add_action( 'do_feed_rdf', 'surge_disable_feed', 1 );
add_action( 'do_feed_rss', 'surge_disable_feed', 1 );
add_action( 'do_feed_rss2', 'surge_disable_feed', 1 );
add_action( 'do_feed_atom', 'surge_disable_feed', 1 );
add_action( 'do_feed_rss2_comments', 'surge_disable_feed', 1 );
add_action( 'do_feed_atom_comments', 'surge_disable_feed', 1 );
remove_action( 'wp_head', 'feed_links', 2 );