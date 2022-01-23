<?php get_header(); ?>

<?php
  //get tags list
	$tags = get_the_tag_list();

  $category = get_the_category(); 
  $category_id = $category[0]->cat_ID;

  $category_link = get_category_link( $category_id );
  $category_name = $category[0]->name;
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
  <div class="container mb-xs-6">
    <?php the_content(); ?>
  </div>

  <div class="tag-container">

  </div>
  
  <div class="author-container">

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
          <div class="pervious-comments">
            <ol>
              <?php // comments list
                wp_list_comments( array(
                  'style'       => 'ol',
                  'short_ping'  => true,
                  'avatar_size' => 74,
                ) );
              ?>
            </ol>
          </div>

          <div class="comment-form">
            <?php comment_form(); ?>
          </div>
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