<?php get_header(); ?>

<?php
	$offset = 6;

	$args = array(
		'posts_per_page' => $offset,
		'post_status' => 'publish'
	);
	
	$articles = new WP_Query( $args );
  $total  = $articles->found_posts;
?>

<main>
	<div class="feature-container">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<!-- feature post -->
				</div>
				<div class="col-md-4">
					<!-- sidebar -->
				</div>
			</div>
		</div>

	</div>
	<div class="post-cards-container">
		<div id="posts" class="related-posts-container" data-offset="<?php echo $offset; ?>" data-total="<?php echo $total; ?>">
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
					<button id="latest-load-more" class="load-more-button load-more-text">Load More <span class="load"></span></button>
	      		</div>
			</div>
		<?php } ?>
	</div>
</main>

<?php get_footer(); ?>