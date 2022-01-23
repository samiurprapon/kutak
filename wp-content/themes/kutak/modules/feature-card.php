<div class="feature-card">
  <?php
    $category = get_the_category(); 
    $category_id = $category[0]->cat_ID;

    $category_link = get_category_link( $category_id );
    $category_name = $category[0]->name;
  ?>

  <div class="image-container">
    <a href="<?php the_permalink(); ?>">
      <?php if (has_post_thumbnail()) { ?>
        <div class="card-image"><?php the_post_thumbnail('large'); ?></div>
      <?php } else { ?>
        <div class="card-image">
          <img src="<?php image_url( 'favicon-32x32.png' ); ?>" alt="<?php the_title(); ?>">
      <?php } ?>
    </a>
  </div>


  <div class="card-content">
		<a href="<?php echo $category_link; ?>" class="category-title">
      <div class="card-category">
        <span><i class="far fa-folder"></i></span>
        <span class="category-title"><?php echo $category_name ?></span>
      </div>
    </a>
    <h2 class="card-title"><?php the_title(); ?></h2>
    
    <div class="card-excerpt"><?php echo get_post_meta(get_the_ID(), 'short-description', true); ?></div>
    <div class="post-meta">
      <span><i class="far fa-clock"></i><?php echo read_time() ?></span>
      <!-- ex: March 14, 2022 -->
      <span><i class="far fa-calendar-alt"></i><?php the_time( 'F j, Y' ); ?></span> 
    </div>
  </div>
</div>