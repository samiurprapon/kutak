
<div class="feature-tabs">
	<button id="feature-1" class="feature-tab is-active">Trending</button>
	<button id="feature-2" class="feature-tab">Recommended</button>
</div>
<?php 
	$trending_post_args = array(
		'post_status' => 'publish',
		'orderby' => 'date',
		'order' => 'DESC',
		'posts_per_page' => 4,
		'offset' => 0,
		'meta_query' => array(
			array(
				'key' => 'post-type',
				'value' => 'trending',
			),
		)
	);
			
		$trending_posts = new WP_query ( $trending_post_args );
	?>

<div id="trending-posts" class="container pl-xs-0" data-total="<?php echo $trending_posts->found_posts; ?>">
	<div class="row">
		<?php if ( $trending_posts->have_posts() ): ?>
			<?php while ( $trending_posts->have_posts()) : $trending_posts->the_post(); ?>
				<div class="col-xs-12 col-sm-6 col-md-12">
					<?php get_template_part( 'modules/side-card' ); ?>
				</div>
			<?php endwhile; wp_reset_query();?>
		<?php endif; ?>		
	</div>
</div>

<?php
	$recommended_post_args = array(
		'post_status' => 'publish',
		'orderby' => 'date',
		'posts_per_page' => 4,
		'offset' => 0,
		'meta_query' => array(
			array(
				'key' => 'post-type',
				'value' => 'recommended',
				'compare' => 'EXISTS'
			),
		)
	);
		
	$recommended_posts = new WP_query ( $recommended_post_args );
?>
<div id="recommended-posts" class="container pl-xs-0 hide" data-total="<?php echo $recommended_posts->found_posts; ?>">
	<div class="row">
		<?php if ( $recommended_posts->have_posts() ): ?>
			<?php while ( $recommended_posts->have_posts()) : $recommended_posts->the_post(); ?>
				<div class="col-xs-12 col-sm-6 col-md-12">
					<?php get_template_part( 'modules/side-card' ); ?>
				</div>
			<?php endwhile; wp_reset_query();?>
		<?php endif; ?>		
	</div>
</div>