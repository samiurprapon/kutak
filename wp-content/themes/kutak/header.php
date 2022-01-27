<?php get_template_part('framework/head'); ?>

<?php
	$categories = get_categories( array(
	  'orderby' => 'name',
		'order'   => 'ASC',
		) 
	);

?>

<header>
  <?php if( is_home() || is_category() || is_single() ){  ?>
    <div class="header-background p-xs-1 smokey-background">
  <?php } else{ ?>
    <div class="header-background p-xs-1 white-background">
  <?php } ?>

    <nav class="nav">
      <div class="container">
        <div class="row">
          <ul class="col-xs-12 col-md-3 col-lg-2 p-xs-1">
            <li id="hamburger-menu">
              <span class="nav-menu-bar"><i></i></span>
            </li>
            <li>
              <a href="<?php echo get_home_url(); ?>">
                <img src="https://demo.apalodi.com/kutak/wp-content/themes/kutak/assets/img/logo.png"/>
              </a>
            </li>
            <li id="search-button">
              <span class="fas fa-search"></span>
            </li>
          </ul>
        </div>
      </div>
      <section class="search-section">
        <div class="container">
          <div class="row">
            <?php get_search_form(); ?>
          </div>
        </div>
      </section>
      <section class="nav-expand-section">
        <div class="container">
          <div class="row">
            <div class="categories-container">
              <?php foreach ( $categories as $category ) { ?>
                <div class="col-xs-6 col-md-3 pb-xs-2">
                  <a href="<?php echo get_category_link( $category->term_id ); ?>">
                    <div class="card">
                      <div class="category-name">
                        <?php echo $category->name; ?>
                      </div>
                    </div>
                  </a>
                </div>
              <?php } ?>
            </div>
          </div>
          <div class="row mt-xs-4">
            <div class="footer-menu">
              <?php surge_custom_menu( 'footer-menu' );?>
	          </div>
          </div>
          <div class="row">
          	<div class="footer-social">
              <div class="social-icons">
                <a href="#" target="_blank"><i class="fab fa-facebook-square"></i></a>
                <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="#" target="_blank"><i class="fab fa-google-plus-g"></i></a>
              </div>
	          </div>
          </div>
        </div>
      </section>
    </nav>
  </div>
</header>