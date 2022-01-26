<?php get_header(); ?>

<?php

  $category = get_the_category(); 
  $category_id = $category[0]->cat_ID;

  $category_link = get_category_link( $category_id );
  $category_name = $category[0]->name;

  global $post;
  $author_id = $post->post_author;
?>

<div class="post-banner mb-xs-4">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-6">
        <div class="image-container">
          <?php if (has_post_thumbnail()) { ?>
            <div class="card-image"><?php the_post_thumbnail('medium'); ?></div>
          <?php } else { ?>
            <div class="card-image">
              <img src="<?php image_url( 'favicon-32x32.png' ); ?>" alt="<?php the_title(); ?>">
            </div>
          <?php } ?>
        </div>
      </div>
      
      <div class="col-xs-12 col-md-6">
        <div class="content">
          <p class="category-name mt-xs-3 mb-xs-2"><span><i class="far fa-folder"></i></span><?php echo $category_name; ?></p>
        
          <h1 class="mt-xs-2"><?php the_title(); ?></h1>
          <div class="post-short-description mt-xs-4 mb-xs-2">
            <p><?php echo get_post_meta(get_the_ID(), 'short-description', true); ?></p>
          </div>

          <div class="post-meta mt-xs-2 mb-xs-2">
            <span><i class="far fa-clock"></i></span>
            <span><?php echo read_time() ?></span>
            <!-- ex: March 14, 2022 -->
            <span><i class="far fa-calendar-alt"></i></span>
            <span><?php the_time( 'F j, Y' ); ?></span> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<main class="blog-post mb-xs-8">
  <div class="container mb-xs-6 main-content">
    <div class="row">
      <div class="col-md-12">
        <?php the_content(); ?>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <?php $tags = get_the_tag_list(); ?>
        <?php if ($tags) { ?>
          <div class="tag-container">
            <h6>Tags</h6>
            <?php echo $tags; ?>
          </div>
        <?php } ?>
      </div>
      <div class="col-md-12">
        <div class="author-container">
          <div class="author-image">
            <?php echo get_avatar( get_the_author_meta( 'ID' ), $author_id ); ?>
          </div>
          <div class="author-info">
            <!-- author name -->
            <h6 class="author-name"><?php echo get_the_author_meta("display_name", $author_id); echo $author;  ?></h6>
            <p><?php echo get_the_author_meta('description', $author_id); ?></p>
          </div>
        </div>
      </div>
      
      
    </div>
  </div>

  


  <div class="join-newsletter-container">

  </div>

  <div class="ads-container">

  </div>

  <div class="related-post-container">

  </div>

  <div class="comments-container pt-xs-10">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <?php comments_template(); ?>
        </div>
        <div class="col-md-4">
          <!-- sidebar -->
					<?php get_sidebar(); ?>
        </div>
      </div>
    </div>
  </div>
</main>

<?php get_footer(); ?>