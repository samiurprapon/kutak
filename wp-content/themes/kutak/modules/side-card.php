<?php
  $category = get_the_category(); 
  $category_id = $category[0]->cat_ID;

  $category_link = get_category_link( $category_id );
  $category_name = $category[0]->name;
?>

<div class="side-card-container">
  <div class="row">
    <div class="col-xs-4 col-md-6">
      <div class="card-image">
        <a href="<?php the_permalink(); ?>">
          <?php if (has_post_thumbnail()) { ?>
            <div class="image-thumb"><?php the_post_thumbnail('medium'); ?></div>
          <?php } else { ?>
            <div class="image-thumb">
              <img src="<?php image_url( 'favicon-32x32.png' ); ?>" alt="<?php the_title(); ?>">
            </div>
          <?php } ?>		
        </a>
      </div>
    </div>
    <div class="col-xs-8 col-md-6 card-content-wrapper">
      <div class="card-content">
        <a href="<?php echo $category_link; ?>" class="category-title">
          <div class="card-category">
            <span><i class="far fa-folder"></i></span>
            <span class="category-title"><?php echo $category_name ?></span>
          </div>
        </a>
        <div class="card-title">
          <h3><?php the_title(); ?></h3>
        </div>
        <div class="post-meta">
          <span><i class="far fa-clock"></i><?php echo read_time() ?></span>
          <!-- ex: March 14, 2022 -->
          <span><i class="far fa-calendar-alt"></i><?php the_time( 'F j, Y' ); ?></span> 
        </div>
	    </div>
    </div>
  </div>
</div>