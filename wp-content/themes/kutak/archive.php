<?php get_header(); ?>


<?php
	$current_category = get_queried_object();
	$offset = 6;

	if( is_search() ){
		$term_args = [
			's' => get_search_query(),
		];
	}
	// condition for category archive
	elseif ( is_category() ) {
		$term_args = [
			'cat' => $current_category->term_id,
		];
	} // condition for tag archive
	elseif ( is_tag() ) {
		$term_args = [
			'tag_id' => $current_category->term_id,
		];
	}

	$args = array_merge( $term_args, [
		'posts_per_page' => $offset,
		'post_status' => 'publish'
	]);
	
	$articles = new WP_Query( $args );
  $total  = $articles->found_posts;
?>

<main>
	<div class="title-container">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="title-bar">
						<div class="category-heading">
							<div class="category-title">
								<?php if( is_search() ): ?>
									<span><i class="fas fa-circle-notch"></i>SEARCH RESULTS FOR</span>
								<?php else: ?>
									<span><i class="fas fa-circle-notch"></i>CATEGORY</span>
								<?php endif; ?>
							</div>
							<h1 class="category-title-text">
								<?php if( is_search() ){
									echo get_search_query();
								} else {
									echo $current_category->name;
								} ?>
							</h1>
							<div class="category-description">
								<p><?php echo $current_category->description; ?></p>
							</div>
						</div>
						<div class="article-count">
							<span class="number-count"><?php echo $total; ?></span>
							<span class="article-placeholder">Articles</span>
						</div>						
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="post-cards-container">
		<div id="posts" class="related-posts-container" data-offset="<?php echo $offset; ?>" data-total="<?php echo $total; ?>" data-category="<?php echo $current_category->term_id; ?>">
			<div class="container">
				<div id="allPosts" class="row">
					<?php if ( $articles->have_posts() ): ?>
						<?php while ( $articles->have_posts() ): $articles->the_post(); ?>
							<div class="col-md-4">
								<?php get_template_part( 'modules/article-card' ); ?>
							</div>
						<?php endwhile; ?>
					<?php endif;?>
					
				</div>
			</div>
		</div>
        <?php if ( $total > $offset)  { ?>
			<div class="load-more-container">
				<div class="text-center">
					<button id="archive-load-more" class="load-more-button load-more-text">Load More <span class="load"></span></button>
	      </div>
			</div>
		<?php } ?>
	</div>
</main>

<?php get_footer(); ?>