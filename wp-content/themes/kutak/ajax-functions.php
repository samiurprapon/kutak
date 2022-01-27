<?php
/**
 * This file will contain all the ajax functionality of the WordPress site
 * @version 1.0.0
 */

/**
 * This will allow to use surge object globally in JS
 *
 * @handle surge is enqueue name of bundle.js
 * @usages in JS file surge.ajax_url to get the value
 */

wp_localize_script( 'bundle', 'surge', [
	//to avoid cross origin header issue, will remove the host from request in dev mode
	'ajax_url'                     => is_production() ? admin_url( 'admin-ajax.php' ) : '/wp-admin/admin-ajax.php',

	// home page load more ajax
	'latest_load_more_nonce'      => wp_create_nonce( 'latest_load_more_nonce' ),

	// category page load more ajax
	'archive_load_more_nonce'      => wp_create_nonce( 'archive_load_more_nonce' ),

	// 
	'surge_filtered_content'    => wp_create_nonce( 'surge_filtered_content' ),

	'surge_subscribe_nonce' => wp_create_nonce( 'surge_subscribe_nonce' ),

	//
	'surge_contact_nonce' => wp_create_nonce( 'surge_contact_nonce' ),

] );


/**
 * Archive Page (Tag) Load more
 */
function surge_archive_load_more() {
	//check the nonce
	check_ajax_referer( 'archive_load_more_nonce', 'security' );

	//requested data
	$type   = $_REQUEST['type'];
	$term   = $_REQUEST['term'];
	$current_type = $_REQUEST['current_type'];
	$current_term = $_REQUEST['current_term'];
	$offset = $_REQUEST['offset'];
	$search = $_REQUEST['search'];
	$category_id = $_REQUEST['category'];


	if ( ( ! $current_type && ! $current_term ) || ( $current_type == $type ) && $type !== 'tag' ) {
		if ( $type === 'tag' ) {
			$term_args = [
				'tag_id' => $term
			];
		} elseif ( $type === 'category' ) {
			$term_args = [
				'cat' => $term
			];
		} elseif ( $type === 'author' ) {
			$term_args = [
				'author' => $term
			];
		} elseif ( $type === 'search' ) {
			$term_args = [
				's' => $term
			];
		}
	} else {
		if ( $current_type === 'tag' ) {
			$term_args = [
				'tax_query' => [
					[
						'taxonomy' => 'post_tag',
						'field' => 'term_id',
						'terms' => [$current_term, $term],
						'operator' => 'AND'
					]
				]
			];
		} elseif ( $current_type === 'category' ) {
			$term_args = [
				'tax_query' => [
					'relation' => 'AND',
					[
						'taxonomy' => 'category',
						'field' => 'term_id',
						'terms' => [$current_term]
					],
					[
						'taxonomy' => 'post_tag',
						'field' => 'term_id',
						'terms' => [$term]
					]
				]
			];
		} elseif ( $current_type === 'search' ) {
			if ( $type === 'search' ) {
				$term_args = [
					's' => $search
				];
			} else {
				$term_args = [
					'cat' => $term,
					's' => $search
				];
			}
		} elseif ( $current_type === 'author' ) {
			$term_args = [
				'tag_id' => $term,
				'author' => $current_term
			];
		}
	}

	if ( $current_type !== 'search' && $search ) {
		$term_args = array_merge( $term_args, [
			's' => $search
		] );
	}

	$num_of_posts = 3;

	//main condition
	$args = array_merge( $term_args, [
		'offset'         => $offset,
		'posts_per_page' => $num_of_posts,
		'post_status'    => 'publish',
	] );

	if ( empty( $args ) ) {
		$args = [
			'post_status'    => 'publish',
			'cat'			 => $category_id,
			'posts_per_page' => $num_of_posts,
			'offset'         => $offset,
		];
	}
	
	//posts query
	$posts = new WP_Query( $args );

	if ( $posts->have_posts() ) { ?>
		<?php while ( $posts->have_posts() ) : $posts->the_post() ?>
		<div class="col-sm-4">
			<?php get_template_part('modules/article-card'); ?>
		</div><!-- ./col-sm-6 -->
		<?php endwhile ?>
	<?php }

	//end the request
	wp_die();
}

add_action( 'wp_ajax_LOAD_MORE_ARCHIVE_POSTS', 'surge_archive_load_more' );
add_action( 'wp_ajax_nopriv_LOAD_MORE_ARCHIVE_POSTS', 'surge_archive_load_more' );


/**
 * Latest Load more
 */
function surge_latest_load_more() {
	//check the nonce
	check_ajax_referer( 'latest_load_more_nonce', 'security' );

	//requested data
	$offset = $_REQUEST['offset'];
	$num_of_posts = 3;

	//main condition
	$args = [
		'category__not_in' => [ get_category_by_slug( 'landing-pages' )->term_id ],
		'posts_per_page'   => $num_of_posts,
		'offset'           => $offset,
		'post_status'      => 'publish'
	];
	//posts query
	$posts = new WP_Query( $args );

	if ( $posts->have_posts() ) { ?>
		<?php while ( $posts->have_posts() ) : $posts->the_post() ?>
		<div class="col-md-4 col-sm-6">
			<?php get_template_part('modules/article-card'); ?>
		</div><!-- ./col-md-4 col-sm-6 -->
		<?php endwhile ?>
	<?php }

	//end the request
	wp_die();
}

add_action( 'wp_ajax_LOAD_MORE_LATEST_POSTS', 'surge_latest_load_more' );
add_action( 'wp_ajax_nopriv_LOAD_MORE_LATEST_POSTS', 'surge_latest_load_more' );


/**
 * Archive Page Filter
 */
function surge_archive_filter() {
	//check the nonce
	check_ajax_referer( 'filter_load_more_nonce', 'security' );

	//requested data
	$type   = $_REQUEST['type'];
	$term   = $_REQUEST['term'];
	$current_type = $_REQUEST['current_type'];
	$current_term = $_REQUEST['current_term'];
	$search = $_REQUEST['search'];
	$offset = $_REQUEST['offset'];

	if ( $current_type === 'tag' ) {
		if ( $type === 'all' ) {
			$term_args = [
				'tax_query' => [
					[
						'taxonomy' => 'post_tag',
						'field' => 'term_id',
						'terms' => [$current_term],
					]
				]
			];
		} else {
			$term_args = [
				'tax_query' => [
					[
						'taxonomy' => 'post_tag',
						'field' => 'term_id',
						'terms' => [$current_term, $term],
						'operator' => 'AND'
					]
				]
			];
		}
	} else if ( $current_type === 'category' ) {
		if ( $type === 'all' ) {
			$term_args = [
				'tax_query' => [
					[
						'taxonomy' => 'category',
						'field' => 'term_id',
						'terms' => [$current_term]
					]
				]
			];
		} else {
			$term_args = [
				'tax_query' => [
					'relation' => 'AND',
					[
						'taxonomy' => 'category',
						'field' => 'term_id',
						'terms' => [$current_term]
					],
					[
						'taxonomy' => 'post_tag',
						'field' => 'term_id',
						'terms' => [$term]
					]
				]
			];	
		}
	} else if ( $current_type === 'author' ) {
		if ( $type === 'all' ) {
			$term_args = [
				'author' => $current_term
			];
		} else {
			$term_args = [
				'author' => $current_term,
				'tag_id' => $term
			];
		}
	} elseif ( $current_type === 'search' ) {
		if ( $type === 'all' ) {
			$term_args = [
				's' => $search
			];	
		} else {
			$term_args = [
				'cat' => $term,
				's' => $search
			];
		}
	}

	if ( $current_type !== 'search' && $search ) {
		$term_args = array_merge( $term_args, [
			's' => $search
		] );
	}

	$num_of_posts = 6;

	//main condition
	$args = array_merge( $term_args, [
		'offset'         => $offset,
		'posts_per_page' => $num_of_posts,
		'post_status'    => 'publish',
	] );

	//posts query
	$posts = new WP_Query( $args );

	$total = $posts->found_posts;

	ob_start();
	if ( $posts->have_posts() ) { ?>
		<?php while ( $posts->have_posts() ) : $posts->the_post() ?>
		<div class="col-sm-4">
			<?php get_template_part('modules/article-card'); ?>
		</div><!-- ./col-sm-6 -->
		<?php endwhile ?>
	<?php }
	$html = ob_get_clean();

	wp_send_json( [
		'total' => $total,
		'posts' => $html
	] );

	//end the request
	wp_die();
}

add_action( 'wp_ajax_ARCHIVE_FILTER_POSTS', 'surge_archive_filter' );
add_action( 'wp_ajax_nopriv_ARCHIVE_FILTER_POSTS', 'surge_archive_filter' );

/**
 * Load content based on filter
 */

if ( ! function_exists( 'surge_ajax_filtered_content' ) ) {
	function surge_ajax_filtered_content() {
		//check the nonce
		check_ajax_referer( 'surge_filtered_content', 'security' );

		$category = trim( $_REQUEST['filter']['category'] );
		$tag      = trim( $_REQUEST['filter']['tags'] );

		//main condition
		$num_of_posts = 6;

		$terms = [
			'posts_per_page' => $num_of_posts,
			'post_status'    => 'publish'
		];

		//conditional
		$posts = get_filtered_wp_query( $terms, $category, $tag );
		//total posts
		$total = $posts->found_posts;

		if ( $posts->have_posts() ) { ?>
			<?php while ( $posts->have_posts() ) : $posts->the_post() ?>
				<div class="col-md-4 col-sm-6">
					<?php get_template_part('modules/article-card'); ?>
				</div><!-- ./col-md-4 col-sm-6 -->
			<?php endwhile ?>
		<?php }

		//end the request
		wp_die();
	}

	add_action( 'wp_ajax_SURGE_FILTERED_CONTENT', 'surge_ajax_filtered_content' );
	add_action( 'wp_ajax_nopriv_SURGE_FILTERED_CONTENT', 'surge_ajax_filtered_content' );
}

/**
 * Get the filtered WordPress query
 *
 * @param $terms
 * @param $category
 * @param $tag
 *
 * @return WP_Query
 */

if ( ! function_exists( 'get_filtered_wp_query' ) ) {
	function get_filtered_wp_query( $terms, $category, $tag ) {
		if ( $category && $tag) {
			$posts = new WP_Query( array_merge( [
				'category_name' => $category,
				'tag__and'      => [
					get_term_by( 'name', $tag, 'post_tag' )->term_id
				],
			], $terms ) );
		} elseif ( $category && $tag ) {
			$posts = new WP_Query( array_merge( [
				'category_name' => $category,
				'tag'           => $tag,
			], $terms ) );
		} elseif ( $category) {
			$posts = new WP_Query( array_merge( [
				'category_name' => $category,
			], $terms ) );
		} elseif ( $tag) {
			$posts = new WP_Query( array_merge( [
				'tag__and' => [
					get_term_by( 'name', $tag, 'post_tag' )->term_id
				],
			], $terms ) );
		} elseif ( $category ) {
			$posts = new WP_Query( array_merge( [
				'cat' => get_category_by_slug( $category )->term_id
			], $terms ) );
		} elseif ( $tag ) {
			$posts = new WP_Query( array_merge( [
				'tag' => $tag,
			], $terms ) );
		} else {
			$posts = new WP_Query( $terms );
		}

		return $posts;
	}
}

/**
 * Newsletter Form Submission
 */
if ( ! function_exists( 'surge_subscribe' ) ) {
	function surge_subscribe() {
		check_ajax_referer( 'surge_subscribe_nonce', 'security' );

		//get the email
		$email = $_REQUEST['email'];

		// call mail server to send the email
		$mail_sent = wp_mail( $email, 'Surge Newsletter', 'You have been subscribed to the Surge Newsletter' );

		// //return the response
		// if ( $mail_sent ) {
		// 	wp_send_json( [
		// 		'success' => true,
		// 		'message' => 'You have been subscribed to the Surge Newsletter'
		// 	] );
		// } else {
		// 	wp_send_json( [
		// 		'success' => false,
		// 		'message' => 'There was an error subscribing you to the Surge Newsletter'
		// 	] );
		// }

		if ( !$email ) {
			wp_send_json( [
				'success' => false,
				'message' => 'Please enter a valid email address'
			] );
		} else {
			wp_send_json( [
				'success' => true,
				'message' => 'You have been subscribed to the Surge Newsletter'
			] );
		}

		wp_die();
	}

	add_action( 'wp_ajax_SURGE_SUBSCRIBE', 'surge_subscribe' );
	add_action( 'wp_ajax_nopriv_SURGE_SUBSCRIBE', 'surge_subscribe' );
}

if ( ! function_exists( 'surge_contact' )) {
	function surge_contact() {
		check_ajax_referer( 'surge_contact_nonce', 'security' );

		// get form data
		$name = $_REQUEST['name'];
		$email = $_REQUEST['email'];
		$subject = $_REQUEST['subject'];
		$message = $_REQUEST['message'];

		// send email
		// $mail_sent = wp_mail( $email, $subject, $message );

		// return response
		// if ( $mail_sent ) {
		// 	wp_send_json( [
		// 		'success' => true,
		// 		'message' => 'Your message has been sent'
		// 	] );
		// } else {
		// 	wp_send_json( [
		// 		'success' => false,
		// 		'message' => 'There was an error sending your message'
		// 	] );
		// }

		if ( !$name || !$email || !$subject || !$message ) {
			wp_send_json( [
				'success' => false,
				'message' => 'Please fill out all the fields'
			] );
		} else {
			wp_send_json( [
				'success' => true,
				'message' => 'Your message has been sent'
			] );
		}
	}
}

add_action( 'wp_ajax_SURGE_CONTACT', 'surge_contact' );
add_action( 'wp_ajax_nopriv_SURGE_CONTACT', 'surge_contact' );