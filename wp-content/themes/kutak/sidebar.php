<?php 
	$trending_post_args = array(
		'posts_per_page' => 4,
		'orderby' => 'publish_date',
		'order' => 'DESC',
		'post_status' => 'publish',
		'meta_query' => array(
			array(
				'key' => 'post-type',
				'value' => 'trending',
			),
		)
	);

	$recommended_post_args = array(
		'posts_per_page' => 4,
		'orderby' => 'date',
		'post_status' => 'publish',
		'meta_query' => array(
			array(
				'key' => 'post-type',
				'value' => 'recommended',
			),
		)
	);

	$trending_posts = new WP_query ( $trending_post_args );
	$recommended_posts = new WP_query ( $recommended_post_args );
?>

<?php if ( $trending_posts->have_posts() ): ?>
	<?php while ( $trending_posts->have_posts()) : $trending_posts->the_post(); ?>
		<?php get_template_part( 'modules/side-card' ); ?>
	<?php endwhile; wp_reset_query();?>
<?php endif; ?>