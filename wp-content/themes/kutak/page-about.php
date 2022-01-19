<?php get_header(); ?>

<main class="about-section">
  <div class="container">
    <div class="row">
	    <h1 class="about-title"><?php echo get_the_title(); ?></h1>
			
			<div class="about-content">
				<?php the_content(); ?>
			</div>
    </div>
  </div>
</main>

<?php get_footer(); ?>
