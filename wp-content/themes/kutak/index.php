<?php get_header(); ?>

<main>
	<div class="feature-container">
		<div class="container">
			<div class="row">
					<!-- feature post -->
					<?php 
						$feature_post_args = array(
							'posts_per_page' => 1,
							'post_status' => 'publish',
							'orderby' => 'date',
							'meta_query' => array(
            		array(
									'key' => 'post-type',
									'value' => 'feature',
								),
            	)
						);

						$feature_post = new WP_query ( $feature_post_args );

						// print_r ( $feature_post );
					?>
					<?php if ( $feature_post->have_posts() ): ?>
						<?php  $feature_post->the_post(); ?>
							<div class="col-md-8">
								<div class="feature-section">
									<?php get_template_part( 'modules/feature-card' ); ?>
								</div>
							</div>
					<?php endif; wp_reset_query();?>
						
				<div class="col-md-4">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</div>

  <div id="filter" class="filter-section">
    <h2><span><i class="far fa-chart-bar"></i></span>Filter our Articles</h2>
    
		<div class="container">
			<div class="filter-options">
				<?php 
					$categories = get_categories( array(
						'orderby' => 'name',
						'order'   => 'ASC',
						) 
					);
				?>
					
				<div class="dropdown dropdown-menu-1" <?php if( is_category() ) { echo 'style="display: none;"'; } ?>>
					<div class="col-md-6 dropdown-parent">
						<div class="items">
							<span class="item-name" data-name="<?php if( is_category() ) { echo get_queried_object()->slug; } ?>">Category</span>
						</div>
						<ul>
							<?php foreach ( $categories as $category ) { ?>
								<li data-name="<?php echo $category->name; ?>"><?php echo $category->name; ?></li>
							<?php } ?>
						</ul>
					</div>
				</div>

				<div class="dropdown dropdown-menu-2">
					<?php $tags = get_tags(); ?>
					<div class="col-md-6 dropdown-parent">
							<div class="items">
								<span class="item-name" data-name="<?php if( is_tag() ) { echo get_queried_object()->slug; } ?>">Topics</span>
							</div>
							<ul <?php if( is_tag() ) { echo 'style="display: none;"'; } ?>>
								<?php foreach ( $tags as $tag ) { ?>
									<li data-name="<?php echo $tag->name; ?>"><?php echo $tag->name; ?></li>
								<?php } ?>
							</ul>
						</div>
				</div>
			</div>
		</div>
  </div>

	<div class="post-cards-container">
		<?php
			$offset = 6;

			$args = array(
				'posts_per_page' => $offset,
				'post_status' => 'publish'
			);
			
			$articles = new WP_Query( $args );
			$total  = $articles->found_posts;
		?>
		<div id="posts" class="related-posts-container" data-offset="<?php echo $offset; ?>" data-total="<?php echo $total; ?>">
			<div class="container">
				<div id="allPosts" class="row">
					<?php if ( $articles->have_posts() ): ?>
						<?php while ( $articles->have_posts() ): $articles->the_post(); ?>
							<div class="col-md-4">
								<?php get_template_part( 'modules/article-card' ); ?>
							</div>
						<?php endwhile; wp_reset_query(); ?>
					<?php endif; ?>
					
				</div>
			</div>
		</div>
    <?php if ( $total > $offset): ?>
			<div class="load-more-container">
				<div class="text-center">
					<button id="latest-load-more" class="load-more-button load-more-text">Load More <span class="load"></span></button>
	      </div>
			</div>
		<?php endif; ?>
	</div>
</main>

<?php get_footer(); ?>