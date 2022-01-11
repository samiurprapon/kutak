<?php get_template_part( 'framework/head' ); ?>
<?php get_template_part( 'header' ); ?>

<main>
	<div class="title-container">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="title-bar">
						<div class="category-heading">
							<div class="category-title">
								<span><i class="fas fa-circle-notch"></i>CATEGORY</span>
							</div>
							<h1 class="category-title-text">
								<?php 
									$category = get_queried_object(); 
									echo get_cat_name( $category->term_id);							
								?>
							</h1>
							<div class="category-description">
								<?php echo category_description( $category->term_id ); ?>
							</div>
						</div>
						<div class="article-count">
							<span class="number-count"><?php echo $category->count ?></span>
							<span class="article-placeholder">Articles</span>
						</div>						
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="post-cards-container">
		<div class="related-posts-container">
			<div class="container">
				<div class="row">
					<div class="related-posts">
						<?php 
							//  get latest posts
							$latest_articles_number = 9;

							$args = array(
								'posts_per_page' => $latest_articles_number,
								'offset' => 6,
								'category' => $category->term_id,
								'post_status' => 'publish',
								'orderby' => 'rand'
							);
								
							$latest_articles = new WP_Query( $args );

							if ( $latest_articles->have_posts() ){ 
								while ( $latest_articles->have_posts() ) { 
									$latest_articles->the_post();
									get_template_part( 'template-parts/post-card' );
								}
							} else{
								echo '<p>No articles found</p>';
							}
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="load-more-container">

		</div>
	</div>

</main>

<?php get_template_part( 'footer' ); ?>
<?php get_template_part( 'framework/foot' ); ?>